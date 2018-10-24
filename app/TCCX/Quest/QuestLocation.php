<?php

namespace App\TCCX\Quest;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TCCX\Quest\QuestLocation
 *
 * @property int $id
 * @property string $name
 * @property float $lat
 * @property float $lng
 * @property string $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TCCX\Quest\Quest[] $quests
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestLocation whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestLocation whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestLocation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestLocation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestLocation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestLocation extends Model
{
    protected $fillable = ['name', 'lat', 'lng', 'type'];
    public function quests()
    {
        return $this->hasMany(Quest::class, 'quest_location_id');
    }
}
