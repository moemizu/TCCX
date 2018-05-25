<?php

use Faker\Generator as Faker;

$factory->define(App\TCCX\MemberGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->realText(100)
    ];
});
