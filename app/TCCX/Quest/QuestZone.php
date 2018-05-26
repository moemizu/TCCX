<?php

namespace App\TCCX\Quest;

use Illuminate\Database\Eloquent\Model;

class QuestZone extends Model
{
    public function quests()
    {
        return $this->hasMany(Quest::class, 'quest_zone_id');
    }
}
