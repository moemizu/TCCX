<?php

namespace App\Http\Controllers\TCCX;

use App\TCCX\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GateLandController extends Controller
{
    public function index()
    {
        $teams = Team::with('money')->get();
        return view('tccx.gate_land.index', ['teams' => $teams]);
    }
}
