<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function __construct()
    {
        //
    }

    /**
     * Создание поста в таблице
     */
    public static function store(array $data): Post
    {
        $imagePath = $data['image_path'] ?? null;
        unset($data['image_path']);

// Убираем tag_ids перед созданием поста
        $tagIds = $data['tag_ids'] ?? [];
        unset($data['tag_ids']);

// Создаем пост
        $post = Post::create($data);

// Сохраняем изображение
        if ($imagePath !== null) {
            $post->image()->create(['image_path' => $imagePath]);
        }

// Привязываем теги
        if (!empty($tagIds)) {
            $post->tags()->sync($tagIds);
        }

        return $post;
    }


    public function update(int $id, array $data)
    {
        $post = Post::find($id);

        if (!$post) {
            return null;
        }

        $post->update($data);
        return $post;
    }

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
