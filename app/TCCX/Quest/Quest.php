<?php

namespace App\TCCX\Quest;

use App\TCCX\Team;
use Illuminate\Database\Eloquent\Model;

/**
 * App\TCCX\Quest\Quest
 *
 * @property int $id
 * @property int $order
 * @property string $name
 * @property int|null $quest_type_id
 * @property int|null $quest_zone_id
 * @property int|null $quest_location_id
 * @property string $difficulty
 * @property string $story
 * @property string $how_to
 * @property string $criteria
 * @property string $meta
 * @property int $reward
 * @property int $multiple_team
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\TCCX\Quest\QuestLocation|null $questLocation
 * @property-read \App\TCCX\Quest\QuestType|null $questType
 * @property-read \App\TCCX\Quest\QuestZone|null $questZone
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TCCX\Team[] $teams
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereCriteria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereDifficulty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereHowTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereMultipleTeam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereQuestLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereQuestTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereQuestZoneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereStory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\Quest whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\TCCX\Quest\QuestLocation|null $quest_location
 * @property-read \App\TCCX\Quest\QuestType|null $quest_type
 * @property-read \App\TCCX\Quest\QuestZone|null $quest_zone
 */
class Quest extends Model
{
    public function quest_type()
    {
        return $this->belongsTo(QuestType::class, 'quest_type_id');
    }

    public function quest_zone()
    {
        return $this->belongsTo(QuestZone::class, 'quest_zone_id');
    }

    public function quest_location()
    {
        return $this->belongsTo(QuestLocation::class, 'quest_location_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class)
            ->withPivot('assigned_at', 'completed_at', 'note')
            ->withTimestamps();
    }

    /**
     * Can you assign this quest to specified team?
     * @return bool
     */
    public function canBeAssigned()
    {
        if ($this->multiple_team) {
            return true;
        } else {
            return !$this->teams()->exists();
        }
    }

    /**
     * Get the team who will do this quest
     * @return Team|null
     */
    public function assignedTo()
    {
        return $this->teams()->first();
    }


    /**
     * Check if quest has been completed
     * @return bool
     */
    public function isCompleted()
    {
        return !empty($this->teams()->first()->pivot->completed_at);
    }
}
