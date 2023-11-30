<?php

namespace Tests\Feature;

use App\Jobs\DownloadFavicon;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class BookmarksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user, 'web');
    }

    /** @test */
    public function should_return_index_page_with_props()
    {
        $this
            ->get(route('bookmarks.index'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('bookmarks/Index')
                    ->where('bookmarks', [])
                    ->where('errors', [])
                    ->where('create_url', route('bookmarks.create'))
        );
    }

    /** @test */
    public function should_return_index_page_with_merged_inertia_props()
    {
        $this
            ->get(route('bookmarks.index'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('bookmarks/Index')
                    ->has('auth.user')
                    ->where('auth.categories', [])
                    ->where('new_bookmark', null)
        );
    }

    /** @test */
    public function should_show_index_page_with_user_data()
    {
        Category::factory()->create();
        Bookmark::factory()->create();

        $this
            ->get(route('bookmarks.index'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('bookmarks/Index')
                    ->count('auth.categories', 1)
                    ->count('bookmarks', 1)
            );
    }

    /** @test */
    public function should_show_create_bookmark_page()
    {
        $this
            ->get(route('bookmarks.create'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('bookmarks/Create')
                    ->where('index_url', route('bookmarks.index'))
                    ->where('store_url', route('bookmarks.store'))
            );
    }

    /** @test */
    public function should_create_a_bookmark()
    {
        Queue::fake();

        Category::factory()->create();
        $bookmark = Bookmark::factory()->make();

        $response = $this->post(route('bookmarks.store'), $bookmark->toArray());
        $response->assertStatus(302);
        $response->assertRedirect(route('bookmarks.index'));
        $response->assertSessionHas('new_bookmark', $bookmark['id']);

        $this->assertDatabaseCount('bookmarks', 1);
        $this->assertDatabaseHas('bookmarks', $bookmark->toArray());

        Queue::assertPushed(DownloadFavicon::class, 1);
    }

    /** @test */
    public function should_show_edit_bookmark_page()
    {
        Category::factory()->create();
        $bookmark = Bookmark::factory()->create();

        $this
        ->get(route('bookmarks.edit', ['bookmark' => $bookmark->id]))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page
            ->component('bookmarks/Edit')
            ->where('index_url', route('bookmarks.index'))
            ->where('edit_url', route('bookmarks.update', ['bookmark' => $bookmark->id]))
            ->where('delete_url', route('bookmarks.delete', ['bookmark' => $bookmark->id]))
        );
    }

    /** @test */
    public function show_update_an_existing_bookmark()
    {
        Queue::fake();

        Category::factory()->create();
        $oldBookmark = Bookmark::factory()->create();
        $newBookmark = Bookmark::factory()->make();

        $response = $this->post(
            route('bookmarks.update', $oldBookmark->id),
            $newBookmark->toArray()
        );

        $response->assertRedirect(route('bookmarks.index'));

        $this->assertDatabaseCount('bookmarks', 1);
        $this->assertDatabaseHas('bookmarks', $newBookmark->toArray());

        Queue::assertPushed(DownloadFavicon::class, 1);
    }

    /** @test */
    public function should_update_bookmark_without_triggering_a_job()
    {
        Queue::fake();

        Category::factory()->create();
        $oldBookmark = Bookmark::factory()->create();
        $newBookmark = Bookmark::factory()->make();

        $newBookmark['url'] = $oldBookmark['url'];

        $response = $this->post(
            route('bookmarks.update', $oldBookmark->id),
            $newBookmark->toArray()
        );

        $response->assertRedirect(route('bookmarks.index'));

        $this->assertDatabaseCount('bookmarks', 1);
        $this->assertDatabaseHas('bookmarks', $newBookmark->toArray());

        Queue::assertPushed(DownloadFavicon::class, 0);
    }

    /** @test */
    public function should_delete_bookmark()
    {
        Category::factory()->create();
        $bookmark = Bookmark::factory()->create();

        $response = $this->delete(route('bookmarks.delete', $bookmark->id));
        $response->assertRedirect(route('bookmarks.index'));

        $this->assertDatabaseCount('bookmarks', 0);

        $this->expectException(ModelNotFoundException::class);
        Bookmark::query()->findOrFail($bookmark->id);
    }

    /**
     * @dataProvider Tests\DataProviders\BookmarkDataProvider::validationCases
     */
    public function test_can_validate_a_bookmark
    (
        string $field,
        string $value,
        bool $shouldSucceed,
        string $errorMsg = ''
    )
    {
        Queue::fake();

        Category::factory()->create();
        $bookmark = Bookmark::factory()->make([ $field => $value ]);
        $response = $this->post(route('bookmarks.store'), $bookmark->toArray());

        if ($shouldSucceed)
        {
            $response->assertSessionHasNoErrors();
        }
        else
        {
            $response->assertSessionHasErrors($field);
            $this->assertEquals($errorMsg, session('errors')->get($field)[0]);
        }
    }
}
