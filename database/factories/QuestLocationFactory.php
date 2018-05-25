<?php

use Faker\Generator as Faker;

$factory->define(App\TCCX\Quest\QuestLocation::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'lat' => $faker->randomFloat(6, -90, 90),
        'lng' => $faker->randomFloat(6, 0, 360),
        'type' => 'default'
    ];
});
