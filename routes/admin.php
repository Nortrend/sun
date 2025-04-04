<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\CheckRoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin', 'middleware' => 'auth'], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('posts', [PostController::class, 'index'])->name('admin.posts.index');
    Route::post('posts', [PostController::class, 'store'])->name('admin.posts.store');
    Route::get('posts/create', [PostController::class, 'create'])->name('admin.posts.create');
    Route::post('posts/{post}/like', [PostController::class, 'toggleLike'])->name('admin.posts.toggleLike');
    Route::get('posts/{post}', [PostController::class, 'show'])->name('admin.posts.show');

    Route::get('articles', [ArticleController::class, 'index'])->name('admin.articles.index');
    Route::post('articles', [ArticleController::class, 'store'])->name('admin.articles.store');
    Route::get('articles/create', [ArticleController::class, 'create'])->name('admin.articles.create');
    Route::get('articles/{article}', [ArticleController::class, 'show'])->name('admin.articles.show');

    Route::get('comments', [CommentController::class, 'index'])->name('admin.comments.index');
    Route::post('comments', [CommentController::class, 'store'])->name('admin.comments.store');
    Route::get('comments/create', [CommentController::class, 'create'])->name('admin.comments.create');
    Route::get('comments/{comment}', [CommentController::class, 'show'])->name('admin.comments.show');

    Route::get('categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('admin.categories.show');

    Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::get('users/list', [UserController::class, 'list'])->name('admin.users.list');
    Route::get('users/{user}', [UserController::class, 'show'])->name('admin.users.show');

    Route::get('profiles', [ProfileController::class, 'index'])->name('admin.profiles.index');
    Route::post('profiles', [ProfileController::class, 'store'])->name('admin.profiles.store');
    Route::get('profiles/create', [ProfileController::class, 'create'])->name('admin.profiles.create');
    Route::get('profiles/{profile}', [ProfileController::class, 'show'])->name('admin.profiles.show');
});
