<?php

namespace Tests\Feature;

use App\Jobs\DownloadFavicon;
use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
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

    public function test_can_create_a_bookmark()
    {
        Queue::fake();

        $bookmark = Bookmark::factory()->make();

        $response = $this->post(route('bookmarks.store'), $bookmark->toArray());
        $response->assertStatus(302);
        $response->assertRedirect(route('bookmarks.index'));
        $response->assertSessionHas('new_bookmark', $bookmark['id']);

        $this->assertDatabaseCount('bookmarks', 1);
        $this->assertDatabaseHas('bookmarks', $bookmark->toArray());

        Queue::assertPushed(DownloadFavicon::class, 1);
    }

    public function test_can_update_bookmark()
    {
        Queue::fake();

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

    public function test_can_update_bookmark_without_job()
    {
        Queue::fake();

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

    public function test_can_delete_bookmark()
    {
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
