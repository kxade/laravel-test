<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function registrationRequiresValidDataViaApi()
    {
        $response = $this->postJson('api/register', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    #[Test]
    public function userCanRegisterViaApi()
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
    public function userCanLoginViaApi()
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
    public function loginFailsWithInvalidCredentialsViaApi()
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
    public function userCanLogoutViaApi()
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
