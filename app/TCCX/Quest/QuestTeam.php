<?php

namespace App\TCCX\Quest;

use App\TCCX\Member;
use App\TCCX\Team;
use Illuminate\Database\Eloquent\Model;

class QuestTeam extends Model
{
    /**
     * Get member who is a quest keeper for this team
     */
    public function questKeeper()
    {
        return $this->belongsTo(Member::class, 'quest_keeper_id');
    }

    /**
     * Refers to (main) Team model
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
