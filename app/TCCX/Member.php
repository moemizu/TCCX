<?php

namespace App\TCCX;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TCCX\Member
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $nick_name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $member_group_id
 * @property int|null $team_id
 * @property-read \App\TCCX\MemberGroup|null $memberGroup
 * @property-read \App\TCCX\Team|null $team
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Member whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Member whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Member whereMemberGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Member whereNickName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Member whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Member whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\TCCX\MemberGroup|null $member_group
 */
class Member extends Model
{
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function member_group()
    {
        return $this->belongsTo(MemberGroup::class, 'member_group_id');
    }
}
