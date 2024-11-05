<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use PHPUnit\Framework\Attributes\Test;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_view_posts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Post::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->get(route('user.posts.index'));

        $response->assertStatus(200)
                 ->assertViewHas('posts');
    }

    #[Test]
    public function user_can_create_a_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $postData = [
            'title' => 'New Post',
            'content' => 'Content of the new post',
        ];

        $response = $this->post(route('user.posts.store'), $postData);

        $response->assertRedirect(route('user.posts.show', Post::latest()->first()))
                 ->assertSessionHas('success', 'Post created successfully!');

        $this->assertDatabaseHas('posts', ['title' => 'New Post']);
    }

    #[Test]
    public function user_can_view_a_single_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('user.posts.show', $post));

        $response->assertStatus(200)
                 ->assertViewHas('post', $post);
    }

    #[Test]
    public function user_can_update_his_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $updatedData = ['title' => 'Updated Title', 'content' => 'Updated Content'];

        $response = $this->put(route('user.posts.update', $post), $updatedData);

        $response->assertRedirect(route('user.posts.show', $post))
                 ->assertSessionHas('success', 'Post was changed successfully!');

        $this->assertDatabaseHas('posts', ['title' => 'Updated Title']);
    }

    #[Test]
    public function user_cant_update_anothers_post()
    {
        $user = User::factory()->create(['id' => 1]);
        $post = Post::factory()->create(['user_id' => $user->id]);
        
        $user2 = User::factory()->create(['id' => 2]);
        $this->actingAs($user2);

        $updatedData = ['title' => 'Updated Title', 'content' => 'Updated Content'];

        $response = $this->put(route('user.posts.update', $post), $updatedData);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('posts', ['title' => 'Updated Title']);
    }

    #[Test]
    public function user_can_delete_his_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->delete(route('user.posts.destroy', $post));

        $response->assertRedirect()
                 ->assertSessionHas('delete', 'Ваш пост был удален');

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    #[Test]
    public function user_cant_delete_anothers_post()
    {
        $user = User::factory()->create(['id' => 1]);
        $post = Post::factory()->create(['user_id' => $user->id]);
        
        $user2 = User::factory()->create(['id' => 2]);
        $this->actingAs($user2);

        $response = $this->delete(route('user.posts.destroy', $post));

        $response->assertStatus(403);

        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }
}
