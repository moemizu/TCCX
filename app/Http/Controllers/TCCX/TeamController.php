<?php

namespace App\Http\Controllers\TCCX;

use App\TCCX\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('tccx.people.team', ['teams' => $teams]);
    }
}
