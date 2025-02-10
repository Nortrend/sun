<?php

namespace App\Http\Controllers;

use App\Http\Resources\Tag\TagResource;
use App\Services\TagServicce;
use Illuminate\Http\JsonResponse;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends Controller
{
    /**
     * Передача объекта класса ProfileService в качестве свойства текущего класса
     */
    public function __construct(private readonly TagServicce $tagService)
    {
    }

    /**
     * Отображение всей таблицы, отформатированной через ресурсный файл
     */
    public function index(): array
    {

        return TagResource::collection(Tag::all())->resolve();
    }

    public function store(): array
    {
        $data = [
            'title' => 'New tag title',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $tag = $this->tagService->store($data);

        return TagResource::make($tag)->resolve();
    }

    /**
     * возвращаем строку из таблицы, с ID который указан в роуте
     * Route::get('/{profile}/show', [ProfileController::class, 'show']);
     */
    public function show(Tag $tag): array
    {

        return TagResource::make($tag)->resolve();
    }

    /**
     * Обновление профиля по ID и возврат результата с учетом обработки ошибок в сервис файле
     */
    public function update(): JsonResponse|array
    {
        $data = [
            'title' => 'Update tag title',
        ];
        $tag = $this->tagService->update(1, $data);

        return $tag
            ? TagResource::make($tag)->resolve()
            : response()->json(['error' => 'Profile not found'], Response::HTTP_NOT_FOUND);
    }

    /**
     * Удаление профиля по ID и возврат результата с учетом обработки ошибок в сервисе
     */
    public function destroy(): JsonResponse
    {
        $deleted = $this->tagService->destroy(6);

        return $deleted
            ? response()->json(['success' => 'Tag deleted successfully'])
            : response()->json(['error' => 'Tag not found'], Response::HTTP_NOT_FOUND);
    }

}
