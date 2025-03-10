<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);
Route::group(['middleware' => 'jwt.auth', 'prefix' => 'auth'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::middleware(['auth', 'check.role:articles'])->group(function () {
    Route::get('/articles', [ArticleController::class, 'index'])->middleware('check.permission:show');
    Route::post('/articles', [ArticleController::class, 'store'])->middleware('check.permission:store');
    Route::get('/articles/{articles}', [ArticleController::class, 'show'])->middleware('check.permission:show');
    Route::patch('/articles/{id}', [ArticleController::class, 'update'])->middleware('check.permission:update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->middleware('check.permission:delete');
});

Route::middleware(['auth', 'check.role:posts'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->middleware('check.permission:show');
    Route::post('/posts', [PostController::class, 'store'])->middleware('check.permission:store');
    Route::get('/posts/{posts}', [PostController::class, 'show'])->middleware('check.permission:show');
    Route::put('/posts/{id}', [PostController::class, 'update'])->middleware('check.permission:update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware('check.permission:delete');
});
//Route::group(['middleware' => 'jwt.auth'], function () {
//    Route::get('/posts', [PostController::class, 'index']);
//    Route::post('/posts', [PostController::class, 'store']);
//    Route::put('/posts/{id}', [PostController::class, 'update']);
//    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
//});


//Route::get('posts', [PostController::class, 'index']);
//Route::post('posts', [PostController::class, 'store']);
//Route::get('posts/{post}', [PostController::class, 'show']);
//Route::patch('posts/{post}', [PostController::class, 'update']);
//Route::delete('posts/{post}', [PostController::class, 'destroy']);
//
//Route::get('profiles', [ProfileController::class, 'index']);
//Route::post('profiles', [ProfileController::class, 'store']);
//Route::get('profiles/{profile}', [ProfileController::class, 'show']);
//Route::patch('profiles/{profile}', [ProfileController::class, 'update']);
//Route::delete('profiles/{profile}', [ProfileController::class, 'destroy']);
//
//Route::get('users', [UserController::class, 'index']);
//Route::post('users', [UserController::class, 'store']);
//Route::get('users/{user}', [UserController::class, 'show']);
//Route::patch('users/{user}', [UserController::class, 'update']);
//Route::delete('users/{user}', [UserController::class, 'destroy']);
//
//Route::get('comments', [CommentController::class, 'index']);
//Route::post('comments', [CommentController::class, 'store']);
//Route::get('comments/{comment}', [CommentController::class, 'show']);
//Route::patch('comments/{comment}', [CommentController::class, 'update']);
//Route::delete('comments/{comment}', [CommentController::class, 'destroy']);



