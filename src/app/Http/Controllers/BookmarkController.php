<?php

namespace App\Http\Controllers;

use App\Jobs\DownloadFavicon;
use App\Http\Requests\StoreBookmarkRequest;
use App\Models\Bookmark;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class BookmarkController extends Controller
{
    // public function index()
    // {
    //     return Inertia::render('bookmarks/Index', [
    //         'bookmarks' => auth()->user()->bookmarks()->get()->map(function($bookmark) {
    //             return [
    //                 'id' => $bookmark->id,
    //                 'name' => $bookmark->name,
    //                 'url' => $bookmark->url,
    //                 'order' => $bookmark->order,
    //                 'category_id' => $bookmark->category_id,
    //                 'edit_url' => route('bookmarks.edit', $bookmark->id),
    //             ];
    //         }),
    //         'create_url' => route('bookmarks.create')
    //     ]);
    // }

    public function create()
    {
        return Inertia::render('bookmarks/Create', [
            'categories' => auth()->user()->categories()->select('id', 'title', 'parent_id')->get(),
            'home_url' => route('home'),
            'store_url' => route('bookmarks.store'),
            'create_category_url' => route('categories.create')
        ]);
    }

    public function edit(Bookmark $bookmark)
    {
        return Inertia::render('bookmarks/Edit', [
            'bookmark' => $bookmark,
            'home_url' => route('home'),
            'update_url' => route('bookmarks.update', ['bookmark' => $bookmark->id]),
            'delete_url' => route('bookmarks.delete', ['bookmark' => $bookmark->id]),
        ]);
    }

    // TODO: Add update favicon with custom image
    public function update(StoreBookmarkRequest $request, Bookmark $bookmark): RedirectResponse
    {
        $validated = $request->validated();

        $bookmark->update($validated);

        if ($bookmark->wasChanged('url'))
        {
            DownloadFavicon::dispatch($bookmark);
        }

        return redirect(route('home'));
    }

    public function updateApi(Bookmark $bookmark)
    {
        $validated = Request::validate([
            'parent_id' => ['required', 'exists:categories,id'],
            'order' => ['required', 'min:1', 'max:255']
        ]);

        $bookmark->update([
            'category_id' => $validated['parent_id'],
            'order' => $validated['order']
        ]);

        return response($bookmark->toJson(), 201);
    }

    public function delete(Bookmark $bookmark)
    {
        $bookmark->delete();
        return redirect(route('home'));
    }

    public function store(StoreBookmarkRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        $new_bookmark = Bookmark::create($validated);

        DownloadFavicon::dispatch($new_bookmark);

        return redirect()
            ->route('home')
            ->with("new_bookmark", $new_bookmark->id);
    }
}
