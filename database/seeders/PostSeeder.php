<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::factory(10)->has(Comment::factory()->count(5),'comments')->create();

        $tags = Tag::all();
        foreach ($posts as $post) {
            $post->tags()->syncWithoutDetaching($tags->random(fake()->numberBetween(1, 5))->pluck('id'));
        }

        $profiles = Profile::all();
        foreach ($posts as $post) {
            $post->likedBy()->syncWithoutDetaching($profiles->random(fake()->numberBetween(1, 5))->pluck('id'));
        }

        $comments = Comment::all(); // все комментарии
        foreach ($posts as $post) {
            foreach ($post->comments as $comment) {
                // Для каждого комментария добавляем случайное количество дочерних комментариев
                $randomComments = $comments->random(fake()->numberBetween(1, 2));
                foreach ($randomComments as $randomComment) {
                    // Добавляем дочерний комментарий
                    $randomComment->parent_id = $comment->id; // Устанавливаем родительский ID
                    $randomComment->save(); // Сохраняем дочерний комментарий
                }
            }
        }
    }
}
