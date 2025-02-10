<?php

namespace App\Http\Controllers;

use App\Http\Resources\Profile\ProfileResource;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ProfileController extends Controller
{
    /**
     * Передача объекта класса ProfileService в качестве свойства текущего класса
     */
    public function __construct(private readonly ProfileService $profileService)
    {
    }
    /**
     * Отображение всей таблицы, отформатированной через ресурсный файл
     */
    public function index(): array
    {

        return ProfileResource::collection(Profile::all())->resolve();
    }

    public function store(): array
    {
        $data = [
            'name' => 'MyName',
            'phone' => '8 810 555 35 35',
            'address' => 'Net address',
            'gender' => 'Helicopter',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $profile = $this->profileService->store($data);

        return ProfileResource::make($profile)->resolve();
    }

    /**
     * возвращаем строку из таблицы, с ID который указан в роуте
     * Route::get('/{profile}/show', [ProfileController::class, 'show']);
     */
    public function show(Profile $profile): array
    {

        return ProfileResource::make($profile)->resolve();
    }

    /**
     * Обновление профиля по ID и возврат результата с учетом обработки ошибок в сервис файле
     */
    public function update(Profile $profile): JsonResponse|array
    {
        $data = [
            'phone' => '8 800 666 46 47',
        ];
        $profile = $this->profileService->update(1, $data);

        return $profile
            ? ProfileResource::make($profile)->resolve()
            : response()->json(['error' => 'Profile not found'], Response::HTTP_NOT_FOUND);
    }

    /**
     * Удаление профиля по ID и возврат результата с учетом обработки ошибок в сервисе
     */
    public function destroy(): JsonResponse
    {
        $deleted = $this->profileService->destroy(6);

        return $deleted
            ? response()->json(['success' => 'Profile deleted successfully'])
            : response()->json(['error' => 'Profile not found'], Response::HTTP_NOT_FOUND);
    }

}
