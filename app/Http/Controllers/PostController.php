<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostResource;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Передача объекта класса PostService в качестве свойства текущего класса
     */
    public function __construct(private readonly PostService $postService)
    {
    }
    /**
     * Отображение всей таблицы, отформатированной через ресурсный файл
     */
    public function index(): array
    {
        return PostResource::collection(Post::all())->resolve();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Создание поста через сервис файл и отображение его отформатированным через ресурс
     */
    public function store(): array
    {
        $data = [
            'title' => 'new post',
            'author' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $post = $this->postService->store($data);

        return PostResource::make($post)->resolve();
    }

    /**
     * возвращаем строку из таблицы, с ID который указан в роуте
     * Route::get('/{post}/show', [PostController::class, 'show']);
     */
    public function show(Post $post): array
    {

        return PostResource::make($post)->resolve();
    }

    /**
     * Обновление поста по ID и возврат результата с учетом обработки ошибок в сервис файле
     */
    public function update(): JsonResponse|array
    {
        $data = [
            'title' => 'new updated x2 post',
        ];
        $post = $this->postService->update(20, $data);

        return $post
            ? PostResource::make($post)->resolve()
            : response()->json(['error' => 'Post not found'], Response::HTTP_NOT_FOUND);
    }

    /**
     * Удаление объекта по ID и возврат результата с учетом обработки ошибок в сервисе
     */
    public function destroy(): JsonResponse
    {
        $deleted = $this->postService->destroy(6);

        return $deleted
            ? response()->json(['success' => 'Post deleted successfully'])
            : response()->json(['error' => 'Post not found'], Response::HTTP_NOT_FOUND);
    }
}
