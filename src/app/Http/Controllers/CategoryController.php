<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function create()
    {
        return Inertia::render('categories/Create', [
            'index_url' => route('bookmarks.index'),
            'store_url' => route('categories.store'),
            'create_bookmark_url' => route('bookmarks.create')
        ]);
    }

    public function edit(Category $category)
    {
        return Inertia::render('categories/Edit', [
            'index_url' => route('bookmarks.index'),
            'update_url' => route('categories.update', ['category' => $category->id]),
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $userId = auth()->user()->id;

        $validated['order'] = Category::lowestOrder(
            $validated['parent_id'],
            $userId
        ) - 10;

        $validated['user_id'] = $userId;

        $category = Category::create($validated);

        if (str_starts_with($request->getRequestUri(), '/api'))
        {
            return response($category->toJson(), 201);
        }

        return redirect(route('bookmarks.index'));
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        $category->update($validated);

        return redirect(route('bookmarks.index'));
    }

    public function delete(Category $category)
    {
        $category->delete();
        return redirect(route('bookmarks.index'));
    }
}
