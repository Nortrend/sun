<?php

namespace App\Http\Controllers;

use App\Http\Resources\Like\LikeResource;
use App\Services\LikeServicce;
use Illuminate\Http\JsonResponse;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LikeController extends Controller
{
    /**
     * Передача объекта класса ProfileService в качестве свойства текущего класса
     */
    public function __construct(private readonly LikeServicce $likeService)
    {
    }

    /**
     * Отображение всей таблицы, отформатированной через ресурсный файл
     */
    public function index(): array
    {

        return LikeResource::collection(Like::all())->resolve();
    }

    public function store(): array
    {
        $data = [
            'author' => 'like author',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $like = $this->likeService->store($data);

        return LikeResource::make($like)->resolve();
    }

    /**
     * возвращаем строку из таблицы, с ID который указан в роуте
     * Route::get('/{profile}/show', [ProfileController::class, 'show']);
     */
    public function show(Like $like): array
    {

        return LikeResource::make($like)->resolve();
    }

    /**
     * Обновление профиля по ID и возврат результата с учетом обработки ошибок в сервис файле
     */
    public function update(): JsonResponse|array
    {
        $data = [
            'author' => 'Update author',
        ];
        $like = $this->likeService->update(1, $data);

        return $like
            ? TagResource::make($like)->resolve()
            : response()->json(['error' => 'Like not found'], Response::HTTP_NOT_FOUND);
    }

    /**
     * Удаление профиля по ID и возврат результата с учетом обработки ошибок в сервисе
     */
    public function destroy(): JsonResponse
    {
        $deleted = $this->likeService->destroy(6);

        return $deleted
            ? response()->json(['success' => 'Like deleted successfully'])
            : response()->json(['error' => 'Like not found'], Response::HTTP_NOT_FOUND);
    }

}
