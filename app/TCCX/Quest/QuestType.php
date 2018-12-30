<?php

namespace App\TCCX\Quest;

use App\TCCX\Criterion;
use Illuminate\Database\Eloquent\Model;

/**
 * App\TCCX\Quest\QuestType
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TCCX\Quest\Quest[] $quests
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TCCX\Criterion[] $criteria
 */
class QuestType extends Model
{
    public function quests()
    {
        return $this->hasMany(Quest::class, 'quest_type_id');
    }

    public function criteria()
    {
        return $this->belongsToMany(Criterion::class, 'quest_type_criterion');
    }
}
