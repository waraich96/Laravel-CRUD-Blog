<?php

use App\Post;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = new Post;
        $post->user_id = 2;
        $post->title = "My First Post";
        $post->body = "First post on the blog, assigned to the admin.";
        $post->save();

        $post = new Post;
        $post->user_id = 2;
        $post->title = "Second Post";
        $post->body = "Second post on the blog also assigned to the admin.";
        $post->save();

        //Creates 20 posts
        factory('App\Post',20)->create();

        
    }
}
