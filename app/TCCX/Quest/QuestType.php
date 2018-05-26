<?php

namespace App\TCCX\Quest;

use Illuminate\Database\Eloquent\Model;

class QuestType extends Model
{
    public function quests()
    {
        return $this->hasMany(Quest::class, 'quest_type_id');
    }
}
