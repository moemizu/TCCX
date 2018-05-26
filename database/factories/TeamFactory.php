<?php

use Faker\Generator as Faker;

$factory->define(App\TCCX\Team::class, function (Faker $faker) {
    return [
        'order' => $faker->unique()->numberBetween(0, 1000),
        'name' => $faker->unique()->firstName,
        'score' => 100,
        'info' => ''
    ];
});
