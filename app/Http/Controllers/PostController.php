<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\File;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        Log::info($request->headers->all());
        $request->validate([
            'body' => ['required', 'string', 'max:500'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $user = $request->user('sanctum'); // get the authenticated user
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $post = Post::create([
            'user_id' => $user->id,
            'body' => $request->body
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $filePath = public_path('images') . '/' . $imageName;
            if ($request->image->move(public_path('images'), $imageName)) {
                $file = File::create([
                    'user_id' => $user->id,
                    'file_path' => $filePath,
                    'post_id' => $post->id
                ]);
            } else {
                $post->delete();
                return response()->json(['message' => 'File upload failed'], 500);
            }
        }

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post,
            'file' => $file ?? null,
        ], 201);
    }

    // public function store(Request $request)
    // {
    //     Log::info($request->headers->all());

    //     // Handle the creation of the new post here...
    // }
}
