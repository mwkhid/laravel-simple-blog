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
        $status = $this->faker->randomElement(['draft', 'published', 'scheduled']);
        $user = $this->faker->randomElement(\App\Models\User::all());
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'status' => $status,
            'user_id' => $user->id,
            'publish_date' => $status === 'draft' ? null : $this->faker->dateTimeBetween('-1 year', '+1 year'),
        ];
    }
}
