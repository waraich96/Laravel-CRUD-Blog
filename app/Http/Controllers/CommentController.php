<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Events\CommentSent;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Post $post)
    {
        $this->validate(request(), [
            'body' => 'required',
        ]);
        $user = auth()->user();
        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'body' => request('body'),
        ]);
        broadcast(new CommentSent($user, $comment))->toOthers();
        return ['status' => 'Message Sent!','comment' => $comment];
    }
    public function index(Post $post)
    {
        return $post->comments()->with('user')->get();
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(null, 204);
    }


    public function update(Request $request, Comment $comment)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $comment->update($request->only(['body']));
        return ['comment' => $comment];
    }
}
