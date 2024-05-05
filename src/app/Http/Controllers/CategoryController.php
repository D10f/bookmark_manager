<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function create()
    {
        return Inertia::render('categories/Create', [
            'home' => route('home'),
            'store_url' => route('categories.store'),
            'create_bookmark_url' => route('bookmarks.create')
        ]);
    }

    public function edit(Category $category)
    {
        return Inertia::render('categories/Edit', [
            'category' => $category,
            'update_url' => route('categories.update', ['category' => $category->id]),
            'delete_url' => route('categories.delete', ['category' => $category->id]),
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $userId = auth()->user()->id;

        // $validated['order'] = Category::lowestOrder(
        //     $validated['parent_id'],
        //     $userId
        // ) - 10;

        $validated['user_id'] = $userId;

        $category = Category::create($validated);

        if (str_starts_with($request->getRequestUri(), '/api'))
        {
            return response($category->toJson(), 201);
        }

        return redirect(route('home'));
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        $category->update($validated);

        return redirect(route('home'));
    }

    public function updateApi(Category $category)
    {
        $validated = Request::validate([
            'parent_id' => ['nullable', 'exists:categories,id'],
            'order' => ['nullable', 'min:1', 'max:255']
        ]);

        $category->update($validated);

        return response($category->toJson(), 201);
    }

    public function delete(Category $category)
    {
        $category->delete();
        return redirect(route('home'));
    }

    public function getBookmarks(Category $category)
    {
        $bookmarks = $category
            ->bookmarks()
            ->select('id', 'url', 'name', 'order')
            ->get()
            ->map(fn ($bookmark) => [
                'id' => $bookmark->id,
                'name' => $bookmark->name,
                'url' => $bookmark->url,
                'order' => $bookmark->order,
                'category_id' => $category->id,
                'edit_url' => route('bookmarks.edit', $bookmark->id),
            ]);

        return response($bookmarks->toJson());
    }
}
