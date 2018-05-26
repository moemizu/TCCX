<?php

namespace App\TCCX;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
