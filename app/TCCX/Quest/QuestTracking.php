<?php

namespace App\TCCX\Quest;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TCCX\Quest\QuestTracking
 *
 * @property int $id
 * @property int|null $team_id
 * @property int|null $assigned_group
 * @property int|null $item_id
 * @property int|null $current_quest_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\TCCX\Quest\Quest|null $quest
 * @property-read \App\TCCX\Team|null $team
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestTracking whereAssignedGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestTracking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestTracking whereCurrentQuestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestTracking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestTracking whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestTracking whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestTracking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestTracking extends Model
{
    public function team()
    {
        return $this->belongsTo('App\TCCX\Team');
    }

    public function quest()
    {
        return $this->belongsTo('App\TCCX\Quest\Quest', 'current_quest_id');
    }

    public function item()
    {
        return $this->belongsTo('App\TCCX\Quest\QuestItem');
    }
}
