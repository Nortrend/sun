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
'profile_id' => Profile::first()->id,
'is_published' => fake()->boolean,
'image_path' => fake()->imageUrl,
'category_id' => Category::inRandomOrder()->first()->id,
'views' => fake()->numberBetween(0, 100),
'published_at' => fake()->dateTime,
        ];
    }
}
