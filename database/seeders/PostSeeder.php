<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Запускает сидер постов.
     */
    public function run(): void
    {
        // Создаем посты с комментариями
        $posts = Post::factory(30)
            ->has(Comment::factory()->count(5), 'comments')
            ->create();

        // Получаем все теги, если они есть
        $tags = Tag::all();
        if ($tags->isNotEmpty()) {
            foreach ($posts as $post) {
                $post->tags()->syncWithoutDetaching(
                    $tags->random(min($tags->count(), fake()->numberBetween(1, 5)))->pluck('id')
                );
            }
        }

        // Получаем все профили, если они есть
        $profiles = Profile::all();
        Post::factory(10)->create([
            'profile_id' => $profiles->random()->id, // Случайный профиль
        ]);
        if ($profiles->isNotEmpty()) {
            foreach ($posts as $post) {
                $post->likedBy()->syncWithoutDetaching(
                    $profiles->random(min($profiles->count(), fake()->numberBetween(1, 5)))->pluck('id')
                );
            }
        }

        // Добавляем дочерние комментарии
        $allComments = Comment::all(); // Получаем все комментарии
        foreach ($posts as $post) {
            foreach ($post->comments as $comment) {
                // Фильтруем комментарии, чтобы исключить родителя из возможных детей
                $availableComments = $allComments->where('id', '!=', $comment->id);

                if ($availableComments->isNotEmpty()) {
                    $randomComments = $availableComments->random(min($availableComments->count(), fake()->numberBetween(1, 2)));

                    foreach ($randomComments as $randomComment) {
                        $randomComment->parent_id = $comment->id; // Устанавливаем родительский ID
                        $randomComment->save(); // Сохраняем дочерний комментарий
                    }
                }
            }
        }
    }
}

