<?php

use Faker\Generator as Faker;

$factory->define(App\TCCX\Member::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'nick_name' => $faker->userName,
    ];
});
