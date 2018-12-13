<?php

namespace App\Http\Controllers\TCCX;

use App\Http\Requests\TCCX\SubmitScore;
use App\SortingRule;
use App\TCCX\Team;
use App\UserSorting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        return view('tccx.scoreboard', ['teams' => $teams, 'sorting' => $sorting]);
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
