<?php

namespace App\Services;

use App\Models\Comment;

class CommentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Создание коммента в таблице
     */
    public function store(array $data): Comment
    {

        return Comment::create($data);
    }

    /**
     * Поиск коммента по ID, его обновление и вывод на экран + обработка ошибок
     */
    public function update(int $id, array $data)
    {
        $comment = Comment::find($id);
        if (!$comment) {

            return null;
        }
        $comment->update($data);

        return $comment;
    }

    /**
     * Поиск коммента по ID, его удаление и вывод на экран сообщения об успехе или неудаче
     */
    public function destroy(int $id): bool
    {
        $comment = Comment::find($id);
        if (!$comment) {

            return false;
        }
        $comment->delete();

        return true;
    }

}
