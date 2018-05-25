<?php

use Faker\Generator as Faker;

$factory->define(App\TCCX\Team::class, function (Faker $faker) {
    return [
        'order' => $faker->numberBetween(0, 1000),
        'name' => $faker->name,
        'score' => 100,
        'info' => ''
    ];
});
