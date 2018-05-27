<?php

namespace App\TCCX\Quest;

use App\TCCX\Team;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    public function questType()
    {
        return $this->belongsTo(QuestType::class, 'quest_type_id');
    }

    public function questZone()
    {
        return $this->belongsTo(QuestZone::class, 'quest_zone_id');
    }

    public function questLocation()
    {
        return $this->belongsTo(QuestLocation::class, 'quest_location_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class)
            ->withPivot('assigned_at', 'completed_at', 'note')
            ->withTimestamps();
    }
}
