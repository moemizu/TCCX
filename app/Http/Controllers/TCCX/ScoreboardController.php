<?php

namespace App\Http\Controllers\TCCX;

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
            ['id', 'order', 'name', 'score'], 'score'
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

}
