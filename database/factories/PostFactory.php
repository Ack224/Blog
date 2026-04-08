<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => \Str::slug($title),
            'lead' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, asText: true),
            'author' => $this->faker->name(),
            'photo' => '📝',
            'is_published' => true,
            'category' => $this->faker->randomElement(['Laravel', 'React', 'AI & Copilot']),
            'user_id' => User::factory(),
        ];
    }
}

