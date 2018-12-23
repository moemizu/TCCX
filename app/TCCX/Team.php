<?php

namespace App\TCCX;

use App\TCCX\Quest\Quest;
use Illuminate\Database\Eloquent\Model;

/**
 * App\TCCX\Team
 *
 * @property int $id
 * @property int $order
 * @property string $name
 * @property int $score
 * @property string $info
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TCCX\Member[] $members
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TCCX\Quest\Quest[] $quests
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Team whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Team whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Team whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Team whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TCCX\Criterion[] $criteria
 */
class Team extends Model
{
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function quests()
    {
        return $this->belongsToMany(Quest::class)
            ->withPivot('assigned_at', 'completed_at', 'note')
            ->withTimestamps();
    }

    public function criteria()
    {
        return $this->belongsToMany(Criterion::class, 'team_criterion')->as('score')
            ->withPivot('value')
            ->withTimestamps();
    }
}
