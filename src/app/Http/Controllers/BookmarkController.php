<?php

namespace App\Http\Controllers;

use App\Jobs\DownloadFavicon;
use App\Http\Requests\StoreBookmarkRequest;
use App\Models\Bookmark;
use App\Services\BookmarkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class BookmarkController extends Controller
{
    public function index()
    {
        $categories = auth()
            ->user()
            ->categories()
            ->select('id','title','order','parent_id')
            ->orderBy('order')
            ->with(['bookmarks' => function ($query) {
                $query->select('id', 'name', 'url', 'order', 'category_id');
                $query->orderByDesc('order');
            }])
            ->get()
            ->map(fn ($category) => [
                'id' => $category->id,
                'title' => $category->title,
                'order' => $category->order,
                'parent_id' => $category->parent_id,
                'bookmarks' => $category->bookmarks->map(fn ($bookmark) => [
                    'id' => $bookmark->id,
                    'name' => $bookmark->name,
                    'url' => $bookmark->url,
                    'order'=> $bookmark->order,
                    'category_id'=> $bookmark->category_id,
                    'edit_url' => route('bookmarks.edit', $bookmark->id)
                ]),
                'edit_url' => route('categories.edit', $category->id)
            ]);

        return Inertia::render('Home', [
            'categories' => $categories,
            'create_bookmark_url' => route('bookmarks.create')
        ]);
    }

    public function create()
    {
        return Inertia::render('bookmarks/Create', [
            'categories' => auth()->user()->categories()->select('id', 'title', 'parent_id')->get(),
            'store_url' => route('bookmarks.store'),
            'create_category_url' => route('categories.create')
        ]);
    }

    public function edit(Bookmark $bookmark)
    {
        return Inertia::render('bookmarks/Edit', [
            'bookmark' => $bookmark,
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

    /**
     * Given a structured JSON array, re-creates the necessary categories and
     * bookmarks, following the provided structure.
     */
    public function importBookmarks()
    {
        $validated = Request::validate([
            'data' => ['required']
        ]);

        BookmarkService::import($validated['data']);

        return redirect(route('home'));

        // ---

        // $compressed_input = file_get_contents("php://input");

        // if (mb_strlen($compressed_input, 'UTF-8') > 5242880)
        // {
        //     return response('File size exceeds maximum allwowed of 5MB', 400);
        // }

        // $bookmark_data = gzinflate(substr($compressed_input, 10));

        // return response($compressed_input);
    }

    public function export()
    {
        return BookmarkService::export();
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
