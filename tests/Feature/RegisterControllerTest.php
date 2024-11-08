<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    #[Test]
    public function registrationIndexPageWorks(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    #[Test]
    public function userCanRegister()
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
    public function registrationRequiresValidData()
    {
        $response = $this->post(route('register.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }
}
