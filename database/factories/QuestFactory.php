<?php

use Faker\Generator as Faker;

$factory->define(App\TCCX\Quest\Quest::class, function (Faker $faker) {
    $difficulty = array_rand([
        'easy', 'normal', 'hard'
    ]);
    $rewards = ['easy' => 100, 'normal' => 200, 'hard' => 300];
    return [
        'order' => $faker->numberBetween(0, 1000),
        'name' => $faker->name,
        'difficulty' => $difficulty,
        'story' => $faker->realText(1000),
        'how_to' => $faker->realText(500),
        'criteria' => $faker->realText(500),
        'meta' => '',
        'reward' => $rewards[$difficulty],
        'multiple_team' => false
    ];
});
