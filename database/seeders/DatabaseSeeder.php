<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $userA = User::factory()->create([
            'name' => 'User A',
            'email' => 'user_a@example.com',
        ]);

        $userB = User::factory()->create([
            'name' => 'User B',
            'email' => 'user_b@example.com',
        ]);

        Post::factory()->create([
            'title' => 'First Post',
            'content' => 'Content of the first post',
            'status' => 'published',
            'user_id' => $userA->id,
            'created_by' => $userA->id,
            'updated_by' => $userA->id,
            'publish_date' => now(),
        ]);

        Post::factory()->create([
            'title' => 'Second Post',
            'content' => 'Content of the second post',
            'status' => 'published',
            'user_id' => $userB->id,
            'created_by' => $userB->id,
            'updated_by' => $userB->id,
            'publish_date' => null,
        ]);

        Post::factory()->create([
            'title' => 'Third Post',
            'content' => 'Content of the third post',
            'status' => 'draft',
            'user_id' => $userA->id,
            'created_by' => $userA->id,
            'updated_by' => $userA->id,
            'publish_date' => null,
        ]);

        Post::factory()->create([
            'title' => 'Fourth Post',
            'content' => 'Content of the fourth post',
            'status' => 'scheduled',
            'user_id' => $userA->id,
            'created_by' => $userA->id,
            'updated_by' => $userA->id,
            'publish_date' => now()->addDays(7),
        ]);

        Post::factory()->create([
            'title' => 'Fifth Post',
            'content' => 'Content of the fifth post',
            'status' => 'draft',
            'user_id' => $userB->id,
            'created_by' => $userB->id,
            'updated_by' => $userB->id,
            'publish_date' => null,
        ]);

        Post::factory()->create([
            'title' => 'Sixth Post',
            'content' => 'Content of the sixth post',
            'status' => 'scheduled',
            'user_id' => $userB->id,
            'created_by' => $userB->id,
            'updated_by' => $userB->id,
            'publish_date' => now()->addDays(7),
        ]);
    }
}
