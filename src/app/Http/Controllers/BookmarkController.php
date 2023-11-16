<?php

namespace App\Http\Controllers;

use App\Jobs\DownloadFavicon;
use App\Models\Bookmark;
use App\Helpers\URL;
use App\Http\Requests\StoreBookmarkRequest;
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
    public function update(StoreBookmarkRequest $request, Bookmark $bookmark): RedirectResponse
    {
        $validated = $request->validated();

        $bookmark->update($validated);

        if ($bookmark->wasChanged('url') && $bookmark->hasValidUrl())
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

    public function store(StoreBookmarkRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        $new_bookmark = Bookmark::create($validated);

        if ($new_bookmark->hasValidUrl())
        {
            DownloadFavicon::dispatch($new_bookmark);
            Log::info('Job dispatched.' . PHP_EOL);
        }

        return redirect()
            ->route('bookmarks.index')
            ->with("new_bookmark", $new_bookmark->id);
    }
}
