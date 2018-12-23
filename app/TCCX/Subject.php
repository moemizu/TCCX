<?php

namespace App\TCCX;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TCCX\Subject
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $weight
 * @property int $single_criterion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TCCX\Criterion[] $criteria
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Subject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Subject whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Subject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Subject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Subject whereSingleCriterion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Subject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Subject whereWeight($value)
 * @mixin \Eloquent
 */
class Subject extends Model
{
    protected $fillable = ['name', 'description', 'weight', 'single_criterion'];

    public function criteria()
    {
        return $this->hasMany('App\TCCX\Criterion');
    }
}
