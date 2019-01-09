<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'post_id' => 33,
        'user_id' => 1,
        'text' => $faker->sentence,
    ];
});
