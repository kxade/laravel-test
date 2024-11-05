<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function registration_index_page_works(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_can_register()
    {   
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'agreement' => true,
        ];

        $response = $this->post(route('register.store'), $data);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', ['email' => $data['email']]);

        $this->assertAuthenticated();
    }

    #[Test]
    public function registration_requires_valid_data()
    {
        $response = $this->post(route('register.store'), []);
    
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }
}
