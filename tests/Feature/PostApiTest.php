<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Category;
use App\Models\User;

class PostApiTest extends TestCase
{
    protected $post;

    protected function setUp(): void
    {
        parent::setUp();

        // Получаем пользователя и профиль
        $this->user = User::where('email', env('TEST_ADMIN_EMAIL'))->first();
        $this->profile = Profile::where('user_id', $this->user->id)->first();
        $this->category = Category::factory()->create();

        // Авторизация и получение токена
        $response = $this->postJson('/api/auth/login', [
            'email' => env('TEST_ADMIN_EMAIL'),
            'password' => env('TEST_ADMIN_PASSWORD')
        ]);

        $this->token = $response->json('access_token');

        // Создаём пост один раз, чтобы использовать в тестах
        $this->post = Post::factory()->create([
            'profile_id' => $this->profile->id,
            'category_id' => $this->category->id,
            'title' => 'Existing Post',
            'is_published' => true,
            'views' => 10,
        ]);
    }

    /** @test */
    public function it_returns_a_post()
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->getJson("/api/posts/{$this->post->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Existing Post',
            ]);
    }

    /** @test */
    public function it_can_create_a_post()
    {
        $postData = [
            'title' => 'New API Post',
            'profile_id' => $this->profile->id,
            'category_id' => $this->category->id,
            'is_published' => true,
            'views' => 50,
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->postJson('/api/posts', $postData);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'New API Post']);

        $this->assertDatabaseHas('posts', [
            'title' => 'New API Post',
        ]);
    }

    /** @test */
    public function it_can_update_a_post()
    {
        $updatedData = [
            'title' => 'Updated Post Title',
            'content' => 'Updated content',
            'is_published' => false,
            'views' => 100,
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->putJson("/api/posts/{$this->post->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Post Title']);

        $this->assertDatabaseHas('posts', [
            'id' => $this->post->id,
            'title' => 'Updated Post Title',
        ]);
    }

    /** @test */
    public function it_can_delete_a_post()
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->deleteJson("/api/posts/{$this->post->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('posts', [
            'id' => $this->post->id,
        ]);
    }
}
