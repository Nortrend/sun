<?php

namespace App\Services;

use App\Models\Post;
use App\Http\Resources\PostResource;

class PostService
{
    public function __construct()
    {
        //
    }

    /**
     * Создание поста в таблице
     */
    public function store(array $data): Post{

        return Post::create($data);
    }

    /**
     * Поиск поста по ID, его обновление и вывод на экран + обработка ошибок
     */
    public function update(int $id, array $data)
    {
        $post = Post::find($id);
        if (!$post) {

            return null;
        }
        $post->update($data);

        return $post;
    }

    /**
     * Поиск поста по ID, его удаление и вывод на экран сообщения об успехе или неудаче
     */
    public function destroy(int $id): bool
    {
        $post = Post::find($id);
        if (!$post) {

            return false;
        }
        $post->delete();

        return true;
    }

}
