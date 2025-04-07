<?php

namespace App\Services;

use App\Models\Permission;

class PermissionService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Создание категории в таблице
     */
    public function store(array $data): Permission
    {

        return Permission::create($data);
    }

    /**
     * Поиск категории по ID, его обновление и вывод на экран + обработка ошибок
     */
    public function update(int $id, array $data)
    {
        $role = Permission::find($id);
        if (!$role) {

            return null;
        }
        $role->update($data);

        return $role;
    }

    /**
     * Поиск категории по ID, его удаление и вывод на экран сообщения об успехе или неудаче
     */
    public function destroy(int $id): bool
    {
        $role = Permission::find($id);
        if (!$role) {

            return false;
        }
        $role->delete();

        return true;
    }
}
