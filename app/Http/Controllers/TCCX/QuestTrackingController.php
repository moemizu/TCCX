<?php

namespace App\Http\Controllers\TCCX;

use App\TCCX\Quest\Quest;
use App\TCCX\Quest\QuestType;
use App\TCCX\Team;
use App\Http\Controllers\Controller;

class QuestTrackingController extends Controller
{
    public function index()
    {
        $teams = Team::with('quests')->get();
        $states = $this->buildQuestStates($teams);
        return view('tccx.quest.tracking', ['teams' => $teams, 'states' => $states]);
    }

    private function buildQuestStates($teams)
    {
        $qc = app('App\TCCX\Quest\QuestCode');
        $states = [];
        /** @var Team $team */
        foreach ($teams as $team) {
            $states[$team->id] = [];
            // Current Quest
            $latest = $team->quests()->orderByDesc('pivot_assigned_at')->first();
            /** @var Quest $latest */
            if (!empty($latest) && !empty($latest->pivot->assigned_at) && empty($latest->pivot->completed_at)) {
                $states[$team->id]['current_quest'] = $qc->generate($latest);
            } else {
                $states[$team->id]['current_quest'] = null;
            }
            // Quest type counting
            $types = QuestType::all();
            foreach ($types as $type) {
                $states[$team->id][$type->code] = [];
                // Morning and afternoon
                foreach (['X' => 0, 'M' => 1, 'A' => 2] as $timeCode => $time) {
                    $queryWithTime = $team->quests();
                    $queryWithTime->whereHas('quest_type', function ($query) use ($type) {
                        $query->where('id', $type->id);
                    })->where('time', $time)->wherePivot('completed_at', '!=', null);
                    $states[$team->id][$type->code][$timeCode] = $queryWithTime->count();
                }
            }
        }
        return $states;
    }
}
