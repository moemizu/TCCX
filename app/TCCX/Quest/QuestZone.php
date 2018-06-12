<?php

namespace App\TCCX\Quest;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TCCX\Quest\QuestZone
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TCCX\Quest\Quest[] $quests
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestZone whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestZone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestZone whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestZone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestZone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestZone whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestZone extends Model
{
    public function quests()
    {
        return $this->hasMany(Quest::class, 'quest_zone_id');
    }
}
