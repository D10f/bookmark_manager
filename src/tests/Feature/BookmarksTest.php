<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookmarksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_app_homepage_redirects_unauthenticated()
    {
        $response = $this->get('/app');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function a_user_can_create_a_bookmark()
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'name' => $this->faker->title,
            'url' => $this->faker->url,
            'category' => $this->faker->word
        ];

        $response = $this->post('/app/bookmarks/create', $attributes);

        $response->assertStatus(200);

        $this->assertDatabaseHas('bookmarks', $attributes);
    }
}
