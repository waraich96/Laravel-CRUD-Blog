<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Comment;
use App\Post;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $comment = new Comment;
        $comment->user_id = 2;
        $comment->post_id = 2;
        $comment->body = "First post on the blog, assigned to the admin.";
        $comment->save();

        //Creates 20 comments
        factory('App\Comment',20)->create();
    }
}


