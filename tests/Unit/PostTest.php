<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Post;
use Tests\TestCase;

class PostTest extends TestCase
{
//    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_post()
    {
        $post = Post::factory()->create();

        $this->assertDatabaseHas('posts', [
            'title' => $post->title,
            'content' => $post->content,
        ]);
    }

    /** @test */
    public function it_belongs_to_a_category()
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id]);

        $this->assertEquals($category->id, $post->category->id);
    }
}
