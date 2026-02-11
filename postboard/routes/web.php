<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
| If user is logged in → go to posts
| If guest → go to login
*/

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('posts.index')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Guest Routes (only NOT logged-in users)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.submit');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (only logged-in users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Posts index
    Route::get('/posts', [PostController::class, 'index'])
        ->name('posts.index');

    // Create
    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');

    // Deleted Posts
    Route::get('/posts/deleted', [PostController::class, 'deleted'])
        ->name('posts.deleted');

    // My Posts
    Route::get('/posts/mine', [PostController::class, 'myPosts'])->name('posts.mine');

    Route::patch('/posts/{id}/restore', [PostController::class, 'restore'])
        ->name('posts.restore');

    // Read
    Route::get('/posts/{id}', [PostController::class, 'show'])
        ->name('posts.show');

    // Edit
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');

    Route::put('/posts/{id}', [PostController::class, 'update'])
        ->name('posts.update');

    // Delete
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])
        ->name('posts.destroy');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::post('/posts/{id}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    // Like/Unlike
    Route::post('/posts/{id}/like', [PostController::class, 'toggleLike'])
        ->name('posts.like');
});

// Forgot Password

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
