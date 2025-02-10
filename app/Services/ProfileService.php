<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Profile;

class ProfileService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Создание профиля в таблице
     */
    public function store(array $data): Profile
    {

        return Profile::create($data);
    }

    /**
     * Поиск профиля по ID, его обновление и вывод на экран + обработка ошибок
     */
    public function update(int $id, array $data)
    {
        $profile = Profile::find($id);
        if (!$profile) {

            return null;
        }
        $profile->update($data);

        return $profile;
    }

    /**
     * Поиск поста по ID, его удаление и вывод на экран сообщения об успехе или неудаче
     */
    public function destroy(int $id): bool
    {
        $profile = Profile::find($id);
        if (!$profile) {

            return false;
        }
        $profile->delete();

        return true;
    }


}
