<?php

namespace App\TCCX\Quest;

use Illuminate\Database\Eloquent\Model;

class QuestLocation extends Model
{
    public function quests()
    {
        return $this->hasMany(Quest::class, 'quest_location_id');
    }
}
