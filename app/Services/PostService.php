<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostService
{
    public function __construct()
    {
        //
    }

    /**
     * Создание поста в таблице
     * @throws \Exception
     */
    public static function store(array $data): Post
    {
        DB::beginTransaction();
        $post = null;

        try {
            $imagePath = $data['image_path'] ?? null;
            unset($data['image_path']);

            $tagIds = $data['tag_ids'] ?? [];
            unset($data['tag_ids']);

            $post = Post::create($data);

            if ($imagePath !== null) {
                $post->image()->create(['image_path' => $imagePath]);
            }

            if (!empty($tagIds)) {
                $post->tags()->sync($tagIds);
            }

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Post creation failed', ['error' => $exception->getMessage()]);
            throw $exception;
        }

        return $post;
    }



    public function update(int $id, array $data): Post
    {
        DB::beginTransaction();

        try {
            $post = Post::findOrFail($id);

            $imagePath = $data['image_path'] ?? null;
            unset($data['image_path']);
            unset($data['image']);

            $tagIds = $data['tag_ids'] ?? [];
            unset($data['tag_ids']);

            $post->update($data);

            if ($imagePath !== null) {
                if ($post->image) {
                    $post->image()->update(['image_path' => $imagePath]);
                } else {
                    $post->image()->create(['image_path' => $imagePath]);
                }
            }

            $post->tags()->sync($tagIds);

            DB::commit();

            return $post;
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Ошибка при обновлении поста', [
                'post_id' => $id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
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
