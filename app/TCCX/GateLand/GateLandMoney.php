<?php

namespace App\TCCX\GateLand;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TCCX\GateLand\GateLandMoney
 *
 * @property int $id
 * @property int|null $team_id
 * @property int $money
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\GateLand\GateLandMoney whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\GateLand\GateLandMoney whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\GateLand\GateLandMoney whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\GateLand\GateLandMoney whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\GateLand\GateLandMoney whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\TCCX\Team|null $team
 * @property int $score
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\GateLand\GateLandMoney whereScore($value)
 */
class GateLandMoney extends Model
{
    protected $fillable = ['money'];

    public function team()
    {
        return $this->belongsTo('App\TCCX\Team');
    }
}
