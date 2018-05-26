<?php

namespace App\TCCX;

use Illuminate\Database\Eloquent\Model;

class MemberGroup extends Model
{
    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
