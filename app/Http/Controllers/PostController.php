<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Post;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;

    }

    public function costumPosts()
    {
        $posts = $this->endpointRequest('/posts');
        return view('otherPosts', compact('posts')); 
    }

    public function findById($id)
    {
        return $this->endpointRequest('/posts/'.$id);
    }

    public function endpointRequest($url)
    {
        try {
            $response = $this->client->request('GET', $url);
        } catch (\Exception $e) {
            return [];
        }

        return $this->response_handler($response->getBody()->getContents());
    }

    public function response_handler($response)
    {
        if ($response) {
            return json_decode($response);
        }
        
        return [];
    }


    public function index(Request $request)
    {
        $user = auth()->user()->roles()->first()->name;
        if($user == "writer"){
            $posts = Post::where('user_id',auth()->user()->id)->paginate(5);
            return PostResource::collection($posts);
        }else{
            $posts = Post::latest()->paginate(5);
            return PostResource::collection($posts);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'user_id' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $post = new Post();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = str_slug($request->title) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/posts');
            $imagePath = $destinationPath . "/" . $name;
            $image->move($destinationPath, $name);
            $post->image = $name;
        }

        $post->user_id = $request->user_id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $post = Post::find($id);
        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);
        $post = Post::find($id);
        $post->update($request->only(['title', 'body']));
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json(null, 204);
    }

    public function all()
    {
        $posts = Post::latest()->paginate(5);
        return view('landing', compact('posts'));
    }


    public function single(Post $post)
    {
        return view('single', compact('post'));
    }
}