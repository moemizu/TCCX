<?php

namespace App\TCCX\Quest;


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
        $type = optional($quest->quest_type)->code ?? '';
        $zone = optional($quest->quest_zone)->code ?? '';
        $number = sprintf('%02d', $quest->id);
        return strtoupper($type . $zone . $number);
    }
}