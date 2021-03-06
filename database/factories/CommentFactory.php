<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        //
        'body' => $faker->text(),
        'user_id' => User::inRandomOrder()->first(),
        'post_id' => Post::inRandomOrder()->first(),
    ];
});
