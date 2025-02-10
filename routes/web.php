<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\LikeController;

Route::get('/', function () {
    return view('welcome');
});

//Route::prefix('posts')->group(function () {
//    Route::get('/index', [PostController::class, 'index']);
//    Route::get('/{post}/show', [PostController::class, 'show']);
//    Route::get('/store', [PostController::class, 'store']);
//    Route::get('/update', [PostController::class, 'update']);
//    Route::get('/destroy', [PostController::class, 'destroy']);
//});
//
//Route::prefix('profiles')->group(function () {
//    Route::get('/index', [ProfileController::class, 'index']);
//    Route::get('/{profile}/show', [ProfileController::class, 'show']);
//    Route::get('/store', [ProfileController::class, 'store']);
//    Route::get('/update', [ProfileController::class, 'update']);
//    Route::get('/destroy', [ProfileController::class, 'destroy']);
//});
//
//Route::prefix('comments')->group(function () {
//    Route::get('/index', [CommentController::class, 'index']);
//    Route::get('/{comment}/show', [CommentController::class, 'show']);
//    Route::get('/store', [CommentController::class, 'store']);
//    Route::get('/update', [CommentController::class, 'update']);
//    Route::get('/destroy', [CommentController::class, 'destroy']);
//});
//
//Route::prefix('tags')->group(function () {
//    Route::get('/index', [TagController::class, 'index']);
//    Route::get('/{tag}/show', [TagController::class, 'show']);
//    Route::get('/store', [TagController::class, 'store']);
//    Route::get('/update', [TagController::class, 'update']);
//    Route::get('/destroy', [TagController::class, 'destroy']);
//});
//
//Route::prefix('categories')->group(function () {
//    Route::get('/index', [TagController::class, 'index']);
//    Route::get('/{category}/show', [TagController::class, 'show']);
//    Route::get('/store', [TagController::class, 'store']);
//    Route::get('/update', [TagController::class, 'update']);
//    Route::get('/destroy', [TagController::class, 'destroy']);
//});
//
//Route::prefix('categories')->group(function () {
//    Route::get('/index', [CategoryController::class, 'index']);
//    Route::get('/{category}/show', [CategoryController::class, 'show']);
//    Route::get('/store', [CategoryController::class, 'store']);
//    Route::get('/update', [CategoryController::class, 'update']);
//    Route::get('/destroy', [CategoryController::class, 'destroy']);
//});
//
//Route::prefix('likes')->group(function () {
//    Route::get('/index', [LikeController::class, 'index']);
//    Route::get('/{like}/show', [LikeController::class, 'show']);
//    Route::get('/store', [LikeController::class, 'store']);
//    Route::get('/update', [LikeController::class, 'update']);
//    Route::get('/destroy', [LikeController::class, 'destroy']);
//});
