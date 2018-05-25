<?php

use Faker\Generator as Faker;

$factory->define(App\TCCX\Quest\QuestZone::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'code' => array_rand(['S', 'R']),
        'description' => $faker->realText(100)
    ];
});
