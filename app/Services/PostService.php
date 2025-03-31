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
    public function store(array $data): Post
    {
        $profile = Auth::user()?->profile;

        if (!$profile) {
            throw new \Exception('Профиль пользователя не найден.');
        }

        $data['profile_id'] = $profile->id;

        return Post::create($data);
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
