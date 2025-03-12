<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run()
    {
        $statuses = ['draft', 'published', 'scheduled'];

        foreach ($statuses as $status) {
            Post::factory()->create([
                'status' => $status,
                'publish_date' => $status === 'draft' ? null : now()->addDays(rand(1, 30)),
            ]);
        }
    }
}
