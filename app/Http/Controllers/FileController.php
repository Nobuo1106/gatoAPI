<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048', // validating the file input, max 2MB
        ]);

        $user = $request->user(); // get the authenticated user

        // store the file and get the path
        $path = $request->file('file')->store('uploads');

        // create a new File in the database withv the path and user_id
        $file = new File();
        $file->file_path = $path;
        $file->post_id = $request->post_id;
        $file->user_id = $user->id;
        $file->save();

        return response()->json(['file_path' => $path], 201);
    }
}
