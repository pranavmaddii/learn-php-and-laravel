<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes are loaded by the RouteServiceProvider and are prefixed with /api
*/

// Public routes (no token required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (token required)
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Posts
    Route::get('/posts', function () {
        $posts = Post::active()
            ->with('user:id,username')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($posts);
    });

    Route::post('/posts', function (Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:40',
            'body'  => 'required|string|max:2000',
        ]);

        $post = Post::create([
            'title'   => $validated['title'],
            'body'    => $validated['body'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'post'    => $post,
        ], 201);
    });

    Route::get('/posts/{id}', function ($id) {
        $post = Post::with('user:id,username')->findOrFail($id);
        return response()->json($post);
    });

    Route::post('/posts/{id}/like', function ($id, Request $request) {
        $post = Post::findOrFail($id);
        $user = $request->user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->detach($user->id);
            $liked = false;
        } else {
            $post->likes()->attach($user->id);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $post->likes()->count()
        ]);
    });
});
