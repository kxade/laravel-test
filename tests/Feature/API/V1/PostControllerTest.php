<?php

namespace Tests\Feature\API\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use PHPUnit\Framework\Attributes\Test;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_create_a_post()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $postData = [
            'title' => 'Test Title',
            'content' => 'Test Content',
        ];

        $response = $this->postJson('/api/posts', $postData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['message' => 'Post created successfully!']);
        
        $this->assertDatabaseHas('posts', ['title' => 'Test Title']);
    }

    #[Test]
    public function user_can_view_posts()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        Post::factory()->count(5)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data');
    }

    #[Test]
    public function user_can_view_a_post()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $post = Post::factory()->create();

        $response = $this->getJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => $post->title]);
    }

    #[Test]
    public function user_can_update_his_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum');

        $updatedData = ['title' => 'Updated Title', 'content' => 'Updated Content'];

        $response = $this->putJson("/api/posts/{$post->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Post updated successfully!']);

        $this->assertDatabaseHas('posts', ['title' => 'Updated Title']);
    }

    #[Test]
    public function user_cant_update_anothers_post()
    {
        $user = User::factory()->create(['id' => 1]);
        $post = Post::factory()->create(['user_id' => $user->id]);
        
        $user2 = User::factory()->create(['id' => 2]);
        $this->actingAs($user2, 'sanctum');

        $updatedData = ['title' => 'Updated Title', 'content' => 'Updated Content'];

        $response = $this->putJson("/api/posts/{$post->id}", $updatedData);

        $response->assertStatus(403)
                 ->assertJsonFragment(['message' => 'This action is unauthorized.']);

        $this->assertDatabaseMissing('posts', ['title' => 'Updated Title']);
    }

    #[Test]
    public function user_can_delete_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum');

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(201)
                 ->assertJsonFragment(['message' => 'Post deleted successfully!']);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    #[Test]
    public function user_cant_delete_anothers_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $user2 = User::factory()->create(['id' => 2]);
        $this->actingAs($user2, 'sanctum');

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(403)
                 ->assertJsonFragment(['message' => 'This action is unauthorized.']);

        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }
}
