<?php

namespace App\TCCX\Quest;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TCCX\Quest\QuestItem
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $used
 * @property string|null $usage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestItem whereUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TCCX\Quest\QuestItem whereUsed($value)
 * @mixin \Eloquent
 */
class QuestItem extends Model
{
    //
}
