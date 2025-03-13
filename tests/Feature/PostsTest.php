<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

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

    /** @test */
    public function create_post_page_loads_correctly()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/posts/create');

        $response->assertStatus(200);
        $response->assertSee('Create New Post', false); // Ensure 'Create New Post' is present in the response body
    }

    /** @test */
    public function create_post_page_redirects_if_not_authenticated()
    {
        $response = $this->get('/posts/create');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function store_post_works_correctly()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $postData = [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'status' => 'published',
            'publish_date' => now(),
        ];

        $response = $this->post('/posts', $postData);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
    }

    /** @test */
    public function edit_post_page_loads_correctly()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get('/posts/' . $post->id . '/edit');

        $response->assertStatus(200);
        $response->assertSee('Edit Post');
    }

    /** @test */
    public function update_post_works_correctly()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $updatedData = [
            'title' => 'Updated Post Title',
            'content' => 'Updated content.',
            'status' => 'published',
            'publish_date' => now(),
        ];

        $response = $this->put('/posts/' . $post->id, $updatedData);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', ['title' => 'Updated Post Title']);
    }

    /** @test */
    public function destroy_post_works_correctly()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->delete('/posts/' . $post->id);

        $response->assertRedirect();
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
