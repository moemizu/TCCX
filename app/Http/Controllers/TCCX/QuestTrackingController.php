<?php

namespace App\Http\Controllers\TCCX;

use App\TCCX\Quest\Quest;
use App\TCCX\Quest\QuestItem;
use App\TCCX\Quest\QuestTracking;
use App\TCCX\Quest\QuestType;
use App\TCCX\Team;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestTrackingController extends Controller
{
    public function index()
    {
        $teams = Team::with('quests')->get();
        $items = QuestItem::doesntHave('tracking')->get();
        $states = $this->buildQuestStates($teams);
        return view('tccx.quest.tracking', ['teams' => $teams, 'states' => $states, 'items' => $items]);
    }

    public function setItem(Request $request)
    {
        $team = Team::whereId($request->get('team'))->firstOrFail();
        $item = QuestItem::whereId($request->get('item'))->firstOrFail();
        if (!$team->tracking()->exists()) {
            $team->tracking()->save(new QuestTracking());
        }
        if ($team->tracking->item()->exists()) {
            return back()->with('status', [
                'type' => 'danger',
                'message' => 'Team ' . $team->name . ' already has item'
            ]);
        }
        $team->tracking->item()->associate($item);
        $team->tracking->save();
        return back()->with('status', [
            'type' => 'success',
            'message' => 'Item ' . $item->name . ' has been given to ' . $team->name . '!'
        ]);

    }

    public function setItemStatus(Request $request)
    {
        $team = Team::whereId($request->get('team'))->firstOrFail();
        if (!$team->tracking()->exists()) {
            $team->tracking()->save(new QuestTracking());
        }
        if ($team->tracking->item()->exists()) {
            $team->tracking->item->used = $request->get('used', 0);
            $team->tracking->item->save();
            return back()->with('status', [
                'type' => 'success',
                'message' => 'Status has been updated!'
            ]);
        } else {
            return back()->with('status', [
                'type' => 'danger',
                'message' => 'This team doesn\'t have any item!'
            ]);
        }
    }

    public function setGroup(Request $request)
    {
        $team = Team::whereId($request->get('team'))->firstOrFail();
        $groupNo = $request->get('group');
        if (!$team->tracking()->exists()) {
            $team->tracking()->save(new QuestTracking());
        }
        $team->tracking->assigned_group = $groupNo;
        $team->tracking->save();
        return back()->with('status', [
            'type' => 'success',
            'message' => 'Group no. has been set!'
        ]);
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
