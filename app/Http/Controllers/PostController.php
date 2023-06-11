<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\File;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'body' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $user = $request->user(); // get the authenticated user

        $post = Post::create([
            'user_id' => $user->id,
            'body' => $validated['body']
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);

            File::create([
                'user_id' => $user->id,
                'file_path' => $imageName,
                'post_id' => $post->id
            ]);
        }

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post
        ], 201);
    }
}
