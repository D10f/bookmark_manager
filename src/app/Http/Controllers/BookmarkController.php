<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookmarkController extends Controller
{
    public function index()
    {
        return Inertia::render('bookmarks/Index', [
            'bookmarks_create' => route('bookmarks.create')
        ]);
    }

    public function create()
    {
        return Inertia::render('bookmarks/Create', [
            'bookmarks_index' => route('bookmarks.index'),
            'bookmarks_store' => route('bookmarks.store')
        ]);
    }

    // public function edit(Bookmark $bookmark)
    // {
    //     return Inertia::render('bookmarks/Edit', [
    //         'bookmark' => $bookmark,
    //         'bookmarks_index' => route('bookmarks.index'),
    //         // 'bookmarks_update' => route('bookmarks.update'),
    //     ]);
    // }

    /**
     * See: https://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers
     */
    public function store(Request $request): RedirectResponse
    {

        $bookmark = $request->validate([
            'name' => [ 'required', 'max:255', 'min:1'],
            'url' => ['required', 'url:http,https'],
            'category' => ['required', 'max:255', 'min:1']
        ]);

        Bookmark::create($bookmark);

        return redirect(route('bookmarks.index'));
        // return to_route('sdfsd');
        // return back()->withErrors([]);
    }
}
