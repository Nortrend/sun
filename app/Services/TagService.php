<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Создание тэга в таблице
     */
    public function store(array $data)
    {

        return Tag::create($data);
    }

    /**
     * Поиск тэга по ID, его обновление и вывод на экран + обработка ошибок
     */
    public function update(int $id, array $data)
    {
        $tag = Tag::find($id);
        if (!$tag) {

            return null;
        }
        $tag->update($data);

        return $tag;
    }

    /**
     * Поиск тэга по ID, его удаление и вывод на экран сообщения об успехе или неудаче
     */
    public function destroy(int $id): bool
    {
        $tag = Tag::find($id);
        if (!$tag) {

            return false;
        }
        $tag->delete();

        return true;
    }

}
