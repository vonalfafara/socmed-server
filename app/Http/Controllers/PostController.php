<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Http\Resources\FeedResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FeedResource::collection(Post::orderBy('created_at', 'desc')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'body' => 'required',
            'media' => 'nullable|string'
        ]);

        $post = Post::create([
            'user_id' => auth()->user()->id,
            'body' => $fields['body'],
            'media' => $fields['media']
        ]);

        return response([
            'message' => 'Post Created'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post not found'
            ], 404);
        }

        $fields = $request->validate([
            'body' => 'required',
            'media' => 'nullable|string'
        ]);

        $post->update([
            'body' => $fields['body'],
            'media' => $fields['media']
        ]);

        return response([
            'message' => 'Post Updated'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post not found'
            ], 404);
        }

        $post->delete();

        return response([
            'message' => 'Post Deleted'
        ], 200);
    }

    public function like(string $post_id) {
        $like = Like::where('user_id', auth()->user()->id)->where('post_id', $post_id)->first();

        if ($like) {
            $like->delete();
            return response(200);
        }

        $post = Post::find($post_id);

        if (!$post) {
            return response([
                'message' => 'Post not found'
            ]);
        }

        Like::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post_id
        ]);

        return response(200);
    }

    public function comment(Request $request, string $post_id) {
        $fields = $request->validate([
            'body' => 'required|string'
        ]);

        Comment::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post_id,
            'body' => $fields['body']
        ]);

        return response(200);
    }
}
