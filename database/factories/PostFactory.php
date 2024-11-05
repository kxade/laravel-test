<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Enums\PostSource;


class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            'published' => $this->faker->boolean(80), // 80% chance of being published
            'source' => $this->faker->randomElement([PostSource::App, PostSource::Api]),
            'published_at' => $this->faker->dateTimeThisYear,
            'category_id' => null,
            'user_id' => User::factory(),
            'tags' =>  json_encode($this->faker->words(3)),
        ];
    }
}
