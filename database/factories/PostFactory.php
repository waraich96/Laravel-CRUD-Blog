<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->sentence(6),
        'body' => $faker->text(),
        'user_id' => User::inRandomOrder()->first(),
    ];
});


