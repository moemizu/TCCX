<?php

use Faker\Generator as Faker;

$factory->define(App\TCCX\Member::class, function (Faker $faker) {
    return [
        'first_name' => $faker->unique()->firstName,
        'last_name' => $faker->unique()->lastName,
        'nick_name' => $faker->unique()->userName,
    ];
});
