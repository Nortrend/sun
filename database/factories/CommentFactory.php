<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commentable_type' => Post::inRandomOrder()->first()->id ?? Post::factory(),  // Использует существующий пост или создает новый
            'profile_id' => Profile::inRandomOrder()->first()->id ?? Profile::factory(),  // Использует существующий профиль или создает новый
        ];
    }
}
