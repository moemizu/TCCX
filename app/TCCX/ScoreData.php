<?php

namespace App\TCCX;


class ScoreData
{
    public function generate()
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
        $orderedTeams = [];
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
            $orderedTeams[] = ['sum' => $data[$team->id]['sum'], 'team' => $team];
        }
        $collection = collect($orderedTeams)->sortByDesc('sum');
        $collection->transform(function ($item) {
            unset($item['sum']);
            return $item;
        });
        $orderedTeams = $collection->flatten()->all();
        return ['head' => $subjectCriteria, 'body' => $data, 'teams' => $orderedTeams];
    }
}