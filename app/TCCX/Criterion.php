<?php

namespace App\TCCX;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TCCX\Criterion
 *
 * @property int $id
 * @property int $subject_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\TCCX\Subject $subject
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TCCX\Team[] $teams
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Criterion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Criterion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Criterion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Criterion whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Criterion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Criterion extends Model
{
    protected $table = 'criteria';
    protected $fillable = ['name'];

    public function subject()
    {
        return $this->belongsTo('App\TCCX\Subject');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class)
            ->withPivot('value')
            ->withTimestamps();
    }
}
