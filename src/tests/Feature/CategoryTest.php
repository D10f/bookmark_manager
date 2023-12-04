<?php

namespace Tests\Feature;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user, 'web');
    }

    /** @test */
    public function should_return_create_page()
    {
        $this
            ->get(route('categories.create'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('categories/Create')
                    ->where('index_url', route('bookmarks.index'))
                    ->where('store_url', route('categories.store'))
                    ->where('create_bookmark_url', route('bookmarks.create'))
        );
    }

    /** @test */
    public function should_return_edit_page()
    {
        $category = Category::factory()->create();

        $this
            ->get(route('categories.edit', ['category' => $category->id]))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('categories/Edit')
                    ->where('index_url', route('bookmarks.index'))
                    ->where('update_url', route('categories.update', ['category' => $category->id]))
        );
    }

    /** @test */
    public function should_create_a_new_category()
    {
        $category = Category::factory()->make();

        $response = $this->post(route('categories.store'), $category->toArray());
        $response->assertStatus(302);
        $response->assertRedirect(route('bookmarks.index'));

        $this->assertDatabaseCount('categories', 1);
        $this->assertDatabaseHas('categories', $category->toArray());
    }

    /** @test */
    public function should_create_a_new_category_with_lowest_order()
    {
        $first = Category::factory()->make();
        $second = Category::factory()->make();

        $this->post(route('categories.store'), $first->toArray());
        $response = $this->post(route('categories.store'), $second->toArray());
        $response->assertStatus(302);

        $this->assertDatabaseCount('categories', 2);
        $lowestOrder = Category::lowestOrder($second->id, auth()->user()->id);
        $this->assertEquals(-20, $lowestOrder);
    }

    /** @test */
    public function should_create_a_new_category_through_api_endpoint()
    {
        $category = Category::factory()->make();
        $response = $this->post(route('categories.api.store'), $category->toArray());
        $response->assertStatus(201);
    }

    /** @test */
    public function should_update_an_existing_category()
    {
        $old = Category::factory()->create();
        $new = Category::factory()->make();

        $response = $this->post(route('categories.update', $old->id), $new->toArray());
        $response->assertStatus(302);
        $response->assertRedirect(route('bookmarks.index'));

        $this->assertDatabaseCount('categories', 1);
        $this->assertDatabaseHas('categories', $new->toArray());
    }

    /** @test */
    public function should_delete_an_existing_category_and_associated_bookmarks()
    {
        $category = Category::factory()->create();
        Bookmark::factory()->create();
        Bookmark::factory()->create();
        Bookmark::factory()->create();

        $this->assertDatabaseCount('bookmarks', 3);

        $response = $this->delete(route('categories.delete', $category->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('bookmarks.index'));

        $this->assertDatabaseCount('categories', 0);
        $this->assertDatabaseCount('bookmarks', 0);
    }
}
