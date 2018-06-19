<?php

namespace App\Http\Controllers\TCCX;

use App\Http\Requests\TCCX\SubmitScore;
use App\SortingRule;
use App\TCCX\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScoreboardController extends Controller
{
    private $scoreboardSorting;

    public function __construct()
    {
        $this->scoreboardSorting = new SortingRule(
            ['id', 'order', 'name', 'score'], 'score', 'desc'
        );
    }

    /**
     * Return view of scoreboard front page
     */
    public function index(Request $request)
    {
        // get sorting key, default to score
        $sort = $request->get('sort', 'score');
        list($key, $direction) = $this->scoreboardSorting->keyOrDefault($sort);
        // get all team
        $teams = Team::orderBy($key, $direction)->get();
        return view('tccx.scoreboard', ['teams' => $teams]);
    }

    /**
     * Increase/Decrease team
     * @param SubmitScore $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeScore(SubmitScore $request)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            // team
            $team = Team::whereId($request->get('team'))->first();
            // score
            $score = $request->get('score');
            // new score
            $team->score = $team->score + $score;
            // save
            $team->save();
            // redirect to original page
            return redirect()->route('tccx.scoreboard')
                ->with('status', [
                    'type' => 'success',
                    'message' => 'Score has been updated!'
                ]);
        } else {
            abort(401);
        }
    }

}
