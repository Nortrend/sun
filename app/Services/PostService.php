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

        $post = Post::create($data);

        if ($imagePath !== null) {
            $post->image()->create(['image_path' => $imagePath]);
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
