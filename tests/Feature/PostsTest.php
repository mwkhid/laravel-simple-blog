<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function posts_page_loads_correctly()
    {
        $response = $this->get('/posts');

        $response->assertStatus(200);
        $response->assertSee('Posts');
    }

    /** @test */
    public function single_post_page_loads_correctly()
    {
        $user = \App\Models\User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->get('/posts/' . $post->id);

        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->content);
    }
}
