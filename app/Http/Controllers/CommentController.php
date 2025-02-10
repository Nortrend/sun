<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comment\CommentResource;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Передача объекта класса ProfileService в качестве свойства текущего класса
     */
    public function __construct(private readonly CommentService $commentService)
    {
    }
    /**
     * Отображение всей таблицы, отформатированной через ресурсный файл
     */
    public function index(): array
    {

        return CommentResource::collection(Comment::all())->resolve();
    }

    public function store(): array
    {
        $data = [
            'post' => 'Parent post',
            'content' => 'YOU ARE NOT PREPARED',
            'author' => 'Anybody',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $comment = $this->commentService->store($data);

        return CommentResource::make($comment)->resolve();
    }

    /**
     * возвращаем строку из таблицы, с ID который указан в роуте
     * Route::get('/{profile}/show', [ProfileController::class, 'show']);
     */
    public function show(Comment $comment): array
    {

        return CommentResource::make($comment)->resolve();
    }

    /**
     * Обновление профиля по ID и возврат результата с учетом обработки ошибок в сервис файле
     */
    public function update(): JsonResponse|array
    {
        $data = [
            'content' => 'YOU ARE NOT PREPARED ANYWAY',
        ];
        $comment = $this->commentService->update(2, $data);

        return $comment
            ? CommentResource::make($comment)->resolve()
            : response()->json(['error' => 'Comment not found'], Response::HTTP_NOT_FOUND);
    }

    /**
     * Удаление профиля по ID и возврат результата с учетом обработки ошибок в сервисе
     */
    public function destroy(): JsonResponse
    {
        $deleted = $this->commentService->destroy(6);

        return $deleted
            ? response()->json(['success' => 'Comment deleted successfully'])
            : response()->json(['error' => 'Comment not found'], Response::HTTP_NOT_FOUND);
    }
}
