<?php

namespace App\Http\Controllers;

use App\Jobs\DownloadFavicon;
use App\Models\Bookmark;
use App\Helpers\URL;
use App\Services\FaviconService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class BookmarkController extends Controller
{
    public function index()
    {
        return Inertia::render('bookmarks/Index', [
            'bookmarks' => auth()->user()->bookmarks()->get()->map(function($bookmark) {
                return [
                    'id' => $bookmark->id,
                    'name' => $bookmark->name,
                    'url' => $bookmark->url,
                    'category' => $bookmark->category,
                    'edit_url' => route('bookmarks.edit', $bookmark->id),
                ];
            }),
            'create_url' => route('bookmarks.create')
        ]);
    }

    public function create()
    {
        return Inertia::render('bookmarks/Create', [
            'index_url' => route('bookmarks.index'),
            'store_url' => route('bookmarks.store')
        ]);
    }

    public function edit(Bookmark $bookmark)
    {
        return Inertia::render('bookmarks/Edit', [
            'bookmark' => $bookmark,
            'index_url' => route('bookmarks.index'),
            'edit_url' => route('bookmarks.update', ['bookmark' => $bookmark->id]),
            'delete_url' => route('bookmarks.delete', ['bookmark' => $bookmark->id]),
        ]);
    }

    // TODO: Add update favicon with custom image
    public function update(Bookmark $bookmark, Request $request): RedirectResponse
    {
        $newData = $request->validate([
            'name' => [ 'required', 'max:255', 'min:1'],
            'url' => ['required', 'max:' . env('APP_MAX_URL_LENGTH', 2048), 'min:1'],
            'category' => ['required', 'max:255', 'min:1'],
        ]);

        $bookmark->update($newData);

        if ($bookmark->wasChanged('url') && filter_var($newData['url'], FILTER_VALIDATE_URL))
        {
            DownloadFavicon::dispatch($bookmark);
            Log::info('Job dispatched.' . PHP_EOL);
        }

        return redirect(route('bookmarks.index'));
    }

    public function delete(Bookmark $bookmark)
    {
        $bookmark->delete();
        return redirect(route('bookmarks.index'));
    }

    /**
     * See: https://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers
     */
    public function store(Request $request)
    {
        $bookmark = $request->validate([
            'name' => [ 'required', 'max:255', 'min:1'],
            'url' => ['required', 'max:' . env('APP_MAX_URL_LENGTH', 2048), 'min:1'],
            'category' => ['required', 'max:255', 'min:1'],
        ]);

        $bookmark['user_id'] = auth()->id();

        $new_bookmark = Bookmark::create($bookmark);

        if (filter_var($new_bookmark['url'], FILTER_VALIDATE_URL))
        {
            DownloadFavicon::dispatch($new_bookmark);
            Log::info('Job dispatched.' . PHP_EOL);
        }

        return redirect()->route('bookmarks.index')->with([
            "new_bookmark" => $new_bookmark->id
        ]);
    }
}
