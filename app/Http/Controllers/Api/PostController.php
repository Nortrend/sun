<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\StoreRequest;
use App\Http\Requests\Api\Post\UpdateRequest;
use App\Http\Requests\Api\Post\IndexRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {

        $data = $request->validated();

        $posts = Post::filter($data)->get();

        return PostResource::collection($posts)->response();
    }

    /**
     * Валидация данных, согласно StoreRequest, создание и возврат созданного
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $post = Post::create($data);
        return response()->json(new PostResource($post), 201);

//        return PostResource::make($post, 201)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return PostResource::make($post)->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateRequest $request)
    {
        $post = Post::findOrFail($id);
        $data = $request->validated();
        $post->update($data);
        return PostResource::make($post)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], Response::HTTP_NOT_FOUND);
        }

        $post->delete();

        return response()->json(['success' => 'Post deleted successfully']);
    }

}
