<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realTextBetween(10, 20),
            'content' => fake()->realTextBetween(50, 150),
            'profile_id' => Profile::query()->inRandomOrder()->first()?->id ?? Profile::factory(), // Берем случайный профиль
            'is_published' => fake()->boolean,
            'image_path' => fake()->imageUrl(),
            'category_id' => Category::query()->inRandomOrder()->first()?->id ?? Category::factory(), // Берем случайную категорию
            'views' => fake()->numberBetween(0, 100),
            'published_at' => fake()->dateTime(),
        ];
    }
}
