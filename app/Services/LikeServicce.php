<?php

namespace App\Services;

use App\Models\Like;

class LikeServicce
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
    public function store(array $data): Like
    {

        return Like::create($data);
    }

    /**
     * Поиск категории по ID, его обновление и вывод на экран + обработка ошибок
     */
    public function update(int $id, array $data)
    {
        $like = Like::find($id);
        if (!$like) {

            return null;
        }
        $like->update($data);

        return $like;
    }

    /**
     * Поиск категории по ID, его удаление и вывод на экран сообщения об успехе или неудаче
     */
    public function destroy(int $id): bool
    {
        $like = Like::find($id);
        if (!$like) {

            return false;
        }
        $like->delete();

        return true;
    }
}
