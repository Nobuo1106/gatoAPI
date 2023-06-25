<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{RegisterController, SigninController, PostController, CommentController};
use Illuminate\Support\Facades\Log;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('signin', [SigninController::class, 'signIn']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('posts', [PostController::class, 'store']);
    // any other routes that need authentication
});
// Route::middleware('auth:sanctum')->post('posts', [PostController::class, 'store']);
Route::apiResource('comments', CommentController::class);
Route::post('test', function() {
    return response()->json(['message' => 'Post request received']);
});
// Route::get('test', function() {
//     return response()->json(['message' => 'Post request received']);
// });

