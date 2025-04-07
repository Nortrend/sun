<?php

namespace App\Http\Controllers;

use App\Http\Resources\Role\RoleResource;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Передача объекта класса ProfileService в качестве свойства текущего класса
     */
    public function __construct(private readonly RoleService $roleService)
    {
    }

    /**
     * Отображение всей таблицы, отформатированной через ресурсный файл
     */
    public function index(): array
    {

        return RoleResource::collection(Role::all())->resolve();
    }

    public function store(): array
    {
        $data = [
            'title' => 'New role title',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $role = $this->roleService->store($data);

        return RoleResource::make($role)->resolve();
    }

    /**
     * возвращаем строку из таблицы, с ID который указан в роуте
     * Route::get('/{category}/show', [ProfileController::class, 'show']);
     */
    public function show(Role $role): array
    {

        return RoleResource::make($role)->resolve();
    }

    /**
     * Обновление роли по ID и возврат результата с учетом обработки ошибок в сервис файле
     */
    public function update(): JsonResponse|array
    {
        $data = [
            'title' => 'Update role title',
        ];
        $role = $this->roleService->update(1, $data);

        return $role
            ? RoleResource::make($role)->resolve()
            : response()->json(['error' => 'Profile not found'], Response::HTTP_NOT_FOUND);
    }

    /**
     * Удаление роли по ID и возврат результата с учетом обработки ошибок в сервисе
     */
    public function destroy(): JsonResponse
    {
        $deleted = $this->roleService->destroy(6);

        return $deleted
            ? response()->json(['success' => 'Role deleted successfully'])
            : response()->json(['error' => 'Role not found'], Response::HTTP_NOT_FOUND);
    }

}
