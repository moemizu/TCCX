<?php

namespace App\TCCX;

use App\TCCX\Quest\Quest;
use Illuminate\Database\Eloquent\Model;

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
}
