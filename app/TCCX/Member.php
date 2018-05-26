<?php

namespace App\TCCX;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function memberGroup()
    {
        return $this->belongsTo(MemberGroup::class, 'member_group_id');
    }
}
