<?php

namespace App\TCCX\Quest;


/**
 * Class QuestCode
 * Format: [Time][Zone][Type][Group No.][Quest No.]
 * 0 -> Morning(M) or Afternoon(A)
 * 1 -> Siam(S) or Rattanakosin(R)
 * 2 -> Main(M) or Side(S) or Lunch(L) or Contest(C)
 * 3 -> 00 for unspecified, 01 to 12 for group 1 to 12
 * 4 -> 01 - 99 item no
 * 5 -> 0 - 4 level(difficulty)
 * @package App\TCCX\Quest
 *
 */
class QuestCode
{
    /**
     * Generate a quest code
     * TODO: Write a test for generate() method
     * @param Quest $quest
     * @return string
     */
    public function generate(Quest $quest)
    {
        $type = optional($quest->quest_type)->code ?? 'X';
        $zone = optional($quest->quest_zone)->code ?? 'X';
        $number = sprintf('%02d', $quest->order);
        $level = $quest->difficulty;
        $time = $quest->time;
        $group = sprintf('%02d', $quest->group);
        return strtoupper($time . $zone . $type . $group . $number . $level);
    }

    /**
     * Parse quest code
     * TODO: Write a test
     * @param string $code
     * @return array
     */
    public function parse(string $code)
    {
        // convert to lower case
        $code = strtolower($code);
        // retrieve type and zone data
        $types = resolve('App\TCCX\Quest\QuestType');
        $zones = resolve('App\TCCX\Quest\QuestZone');
        // data
        $time = substr($code, 0, 1);
        $zone = substr($code, 1, 1);
        $type = substr($code, 2, 1);
        $group = substr($code, 3, 2);
        $orderAndLevel = substr($code, 5);
        $level = substr($orderAndLevel, strlen($orderAndLevel) - 1, 1);
        $order = substr($orderAndLevel, 0, strlen($orderAndLevel) - 1);
        // transform
        $time = ['x' => 0, 'm' => 1, 'a' => 2][$time] ?? 0;
        $zone = $zones->where('code', $zone)->first()->id ?? null;
        $type = $types->where('code', $type)->first()->id ?? null;
        $group = (int)$group;
        $order = (int)$order;
        $level = (int)$level;
        return [
            'time' => $time,
            'zone' => $zone,
            'type' => $type,
            'group' => $group,
            'order' => $order,
            'difficulty' => $level
        ];
    }
}