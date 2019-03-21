<?php

use Faker\Generator as Faker;

$factory->define(\Bean\Activity\Models\Activity::class, function (Faker $faker) {
    return [
        'actor' => ([
            'name' => $faker->name,
            'id' => $faker->randomNumber()
        ]),
        'actor_id' => $faker->randomNumber(),
        'actor_type' => $faker->randomElement(['User', 'Page']),
        'type' => $faker->randomElement(['save', 'share', 'like', 'report', 'message']),
        'object' => ([
            'name' => $faker->name,
            'id' => $faker->randomNumber()
        ]),
        'object_id' => $faker->randomNumber(),
        'object_type' => $faker->randomElement(['User', 'Page', 'Post', 'Photo']),
        'target' => null,
        'meta' => null,
    ];
});
