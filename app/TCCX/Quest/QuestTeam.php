<?php

namespace App\TCCX\Quest;

use App\TCCX\Member;
use App\TCCX\Team;
use Illuminate\Database\Eloquent\Model;

/**
 * App\TCCX\Quest\QuestTeam
 *
 * @property int $id
 * @property int $team_id
 * @property int $quest_keeper_id
 * @property string $location_url
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\TCCX\Member $questKeeper
 * @property-read \App\TCCX\Team $team
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestTeam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestTeam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestTeam whereLocationUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestTeam whereQuestKeeperId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestTeam whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestTeam whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\TCCX\Member $quest_keeper
 */
class QuestTeam extends Model
{
    /**
     * Get member who is a quest keeper for this team
     */
    public function quest_keeper()
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
