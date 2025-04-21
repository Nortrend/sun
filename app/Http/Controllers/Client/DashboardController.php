<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Response;
use Inertia\ResponseFactory;

class DashboardController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $posts = PostResource::collection(Post::all())->resolve();
//        dd($posts);
        return inertia('Client/Dashboard/Index', compact('posts'));
    }

    public function toggleLike(Post $post)
    {
        $profile = auth()->user()->profile;

        if (!$profile) {
            Log::info("Попытка лайка без профиля", ['user_id' => auth()->id()]);
            return response()->json(['message' => 'Profile not found'], 403);
        }

        $isLiked = $post->likedBy()->where('profile_id', $profile->id)->exists();

        if ($isLiked) {
            Log::info("Удаляем лайк", ['profile_id' => $profile->id, 'post_id' => $post->id]);
            $post->likedBy()->detach($profile->id);
        } else {
            Log::info("Добавляем лайк", ['profile_id' => $profile->id, 'post_id' => $post->id]);
            $post->likedBy()->attach($profile->id);
        }

        return response()->json([
            'liked' => !$isLiked,
            'likes_count' => $post->likedBy()->count()
        ]);
    }
}
