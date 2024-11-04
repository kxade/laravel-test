<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function registration_requires_valid_data_via_api()
    {
        $response = $this->postJson('api/register', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    #[Test]
    public function user_can_register_via_api()
    {
        $response = $this->postJson('api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['user', 'token']);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    #[Test]
    public function user_can_login_via_api()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['user', 'token'])
                 ->assertJson(['user' => ['email' => 'test@example.com']]);
    }

    #[Test]
    public function login_fails_with_invalid_credentials_via_api()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401); // Unauthorized
        $response->assertJson(['message' => 'The provided credentials are incorrect.']);
    }

    #[Test]
    public function user_can_logout_via_api()
    {
        $user = User::factory()->create();

        $user->createToken('Test Token')->plainTextToken;

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('api/logout');

        $response->assertStatus(201)
                 ->assertJson(['message' => 'You are logged out']);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }
}