<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['draft', 'published', 'scheduled']),
            'user_id' => \App\Models\User::factory(),
            'created_by' => \App\Models\User::factory(),
            'updated_by' => \App\Models\User::factory(),
            'publish_date' => $this->faker->optional()->dateTimeBetween('-1 year', '+1 year'),
        ];
    }
}
