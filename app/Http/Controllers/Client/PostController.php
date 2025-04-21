<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\StoreRequest;
use App\Http\Requests\Client\Post\StoreCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Profile\ProfileResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Profile;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{

    public function show(Post $post)
    {
        $post = PostResource::make($post)->resolve();
        return inertia('Client/Post/Show', compact('post'));
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

    public function indexComment(Post $post)
    {
        $comments = $post->comments()
            ->with(['profile', 'children.profile'])
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->get();

        $comments->each(function ($comment) {
            $comment->liked = $comment->likedBy->contains(auth()->user()->profile);
            $comment->likes_count = $comment->likedBy->count();
        });


        return CommentResource::collection($comments)->resolve();

    }
    public function storeComment(Post $post, StoreCommentRequest $request)
    {
        $data = $request->validationData();
        $comment = $post->comments()->create($data);

        // Загружаем связи, чтобы Resource отработал корректно
        $comment->load(['profile', 'parent']);

        return CommentResource::make($comment)->resolve();
    }

    public function toggleCommentLike(Comment $comment)
    {
        $profile = auth()->user()->profile;

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 403);
        }

        $isLiked = $comment->likedBy()->where('profile_id', $profile->id)->exists();

        if ($isLiked) {
            $comment->likedBy()->detach($profile->id);
        } else {
            $comment->likedBy()->attach($profile->id);
        }

        return response()->json([
            'liked' => !$isLiked,
            'likes_count' => $comment->likedBy()->count()
        ]);
    }


}
