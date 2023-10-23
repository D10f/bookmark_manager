<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class BookmarkController extends Controller
{
    public function index()
    {
        return Inertia::render('bookmarks/Index');
    }

    public function create()
    {
        return Inertia::render('bookmarks/Create');
    }

    public function edit($bookmark)
    {
        return Inertia::render('bookmarks/Edit', [
            'bookmark' => $bookmark
        ]);
    }
}
