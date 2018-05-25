<?php

use Faker\Generator as Faker;

$factory->define(App\TCCX\Quest\QuestType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'code' => array_rand(['M', 'S', 'L', 'C']),
        'description' => $faker->realText(100)
    ];
});
