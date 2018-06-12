<?php

namespace App\TCCX;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TCCX\MemberGroup
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TCCX\Member[] $members
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\MemberGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\MemberGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\MemberGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\MemberGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\MemberGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberGroup extends Model
{
    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
