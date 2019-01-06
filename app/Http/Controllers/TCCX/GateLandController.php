<?php

namespace App\Http\Controllers\TCCX;

use App\TCCX\GateLand\GateLandMoney;
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

    public function moneyIndex()
    {
        $teams = Team::with('money')->get();
        return view('tccx.gate_land.money', ['teams' => $teams]);
    }

    public function setScore(Request $request)
    {
        $team = $this->getTeamWithMoney($request->get('team'));
        $team->money->score = $request->get('score', $team->money->score);
        $team->money->save();
        return back()
            ->with('status', [
                'type' => 'success',
                'message' => 'Score has been updated!'
            ]);
    }

    public function setMoney(Request $request)
    {
        $team = $this->getTeamWithMoney($request->get('team'));
        $change = $request->get('money', 0);
        if ($request->get('subtract', 0)) $change *= -1;
        $team->money->money += $change;
        $team->money->save();
        return back()
            ->with('status', [
                'type' => 'success',
                'message' => 'Money has been changed!'
            ]);
    }

    private function getTeamWithMoney($teamId)
    {
        $team = Team::whereId($teamId)->firstOrFail();
        if (!$team->money()->exists())
            $team->money()->save(new GateLandMoney());
        return $team;
    }
}
