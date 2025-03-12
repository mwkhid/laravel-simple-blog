<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function home_page_loads_correctly()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
