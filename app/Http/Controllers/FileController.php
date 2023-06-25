<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\File;

class FileController extends Controller
{
    public function uploadImage(Request $request, Post $post)
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);

        $user = $request->user(); // get the authenticated user
        if (!$user || $user->id !== $post->user_id) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $validated['image']->getClientOriginalExtension();
            $filePath = public_path('images') . '/' . $imageName;
            if ($validated['image']->move(public_path('images'), $imageName)) {
                $file = File::create([
                    'user_id' => $user->id,
                    'file_path' => $filePath,
                    'post_id' => $post->id
                ]);
            } else {
                return response()->json(['message' => 'File upload failed'], 500);
            }
        }

        return response()->json([
            'message' => 'Image uploaded successfully',
            'file' => $file ?? null,
        ], 201);
    }
}
