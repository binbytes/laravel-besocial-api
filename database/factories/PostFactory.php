<?php

use Faker\Generator as Faker;

$factory->define(\App\Post::class, function (Faker $faker) {
    return [
        'text' => $faker->sentence,
        'user_id' => factory(\App\User::class)->create()->id,
    ];
});
