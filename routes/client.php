<?php

use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::post('posts/{post}/like', [DashboardController::class, 'toggleLike'])->name('client.posts.toggle-like');
    Route::post('posts/{post}/comments', [PostController::class, 'storeComment'])->name('posts.comments.store');
    Route::get('posts/{post}/comments', [PostController::class, 'indexComment'])->name('posts.comments.index');

    Route::post('comments/{comment}/like', [PostController::class, 'toggleCommentLike'])->name('client.comments.toggle-like');

    Route::get('/profiles/{profile}', [ProfileController::class, 'show'])->name('client.profiles.show');

});
