<?php

namespace App\Http\Controllers\TCCX;

use App\Http\Requests\TCCX\SubmitScore;
use App\SortingRule;
use App\TCCX\Subject;
use App\TCCX\Team;
use App\UserSorting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ScoreboardController extends Controller
{
    private $scoreboardSorting;

    private $keys = ['id' => '', 'order' => '', 'name' => '', 'score' => ''];

    public function __construct()
    {
        $this->scoreboardSorting = new SortingRule(
            $this->keys, 'score', 'desc'
        );
    }

    /**
     * Return view of scoreboard front page
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // get sorting key, default to score
        //$sort = $request->get('sort', 'score');
        //list($key, $direction) = $this->scoreboardSorting->keyOrDefault($sort);
        $sorting = new UserSorting($this->keys, (string)$request->get('sort', ''));
        // get all team
        $query = Team::query();
        foreach ($sorting->whatToSort() as $key => $direction)
            $query->orderBy($key, $direction);
        $teams = $query->get();
        return view('tccx.scoreboard', ['teams' => $teams, 'sorting' => $sorting, 'scoreboard' => $this->generateTableData()]);
    }

    private function generateTableData()
    {
        $subjectCriteria = [];
        $subjects = Subject::with('criteria')->orderBy('order')->get();
        foreach ($subjects as $sub) {
            $subjectCriteria[$sub->id] = [];
            $subjectCriteria[$sub->id]['subject'] = $sub;
            $subjectCriteria[$sub->id]['criteria'] = [];
            foreach ($sub->criteria()->orderBy('order')->get() as $cr) {
                $subjectCriteria[$sub->id]['criteria'][$cr->id] = $cr;
            }
        }
        // calculate raw score
        $data = [];
        $subjectMax = [];
        $teams = Team::with('criteria')->get();
        foreach ($teams as $team) {
            // transform
            $scoreData = $team->criteria->mapWithKeys(function ($item) {
                return [$item->id => $item->score];
            })->all();
            $data[$team->id] = [];
            // read data using subjectCriteria map
            foreach ($subjectCriteria as $subjectId => $subjectBag) {
                $subjectSum = 0;
                $data[$team->id][$subjectId] = [];
                // each criterion
                foreach ($subjectBag['criteria'] as $criterionId => $criterion) {
                    // read score value
                    $data[$team->id][$subjectId][$criterionId] = $scoreData[$criterionId]->value ?? 0;
                    $subjectSum += $data[$team->id][$subjectId][$criterionId];
                }
                // record its own score
                $data[$team->id][$subjectId]['sum'] = $subjectSum;
                // track max score
                if (!array_key_exists($subjectId, $subjectMax))
                    $subjectMax[$subjectId] = -1;
                $subjectMax[$subjectId] = max($subjectMax[$subjectId], $subjectSum);
            }
        }
        // calculate real score
        foreach ($teams as $team) {
            $data[$team->id]['sum'] = $team->score;
            foreach ($subjectCriteria as $subjectId => $subjectBag) {
                if ($subjectMax[$subjectId] > 0) {
                    $score = ($data[$team->id][$subjectId]['sum'] / $subjectMax[$subjectId]) * 100.0;
                    $data[$team->id]['sum'] += $score * $subjectBag['subject']->weight;
                }
            }
            $data[$team->id]['sum'] = round($data[$team->id]['sum']);
        }

        return ['head' => $subjectCriteria, 'body' => $data];
    }

    /**
     * Increase/Decrease team
     * @param SubmitScore $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeScore(SubmitScore $request)
    {
        $allTeam = $request->get('all-team', false);
        $teams = [];
        if ($allTeam) {
            $teams = Team::all();
        } else {
            $teams[] = Team::whereId($request->get('team'))->first();
        }
        // score
        $score = $request->get('score');
        // for every team (or selected one)
        foreach ($teams as $team) {
            // new score
            $team->score = $team->score + $score;
            // save
            $team->save();
        }
        // redirect to original page
        return redirect()->back()
            ->with('status', [
                'type' => 'success',
                'message' => 'Score has been updated!'
            ]);
    }

}
