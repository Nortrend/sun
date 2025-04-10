<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = PostResource::collection(Post::all())->resolve();
        return inertia('Admin/Post/Index', compact(['posts']));
    }

    public function show(Post $post)
    {
        $post->load(['profile', 'image', 'category']);
        $post = PostResource::make($post)->resolve();
        return inertia('Admin/Post/Show', compact('post'));
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

    public function create()
    {
        $categories = CategoryResource::collection(Category::all())->resolve();
        return inertia('Admin/Post/Create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->except('image');
        $post = PostService::store($data);
        return PostResource::make($post)->resolve();
    }

}
