<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Bookmark;

class BookmarkManager
{
    /**
     * Creates bookmark and category.
     *
     * @param  array Hierarchically structured associative array of categories and their bookmarks.
     * @param  int   Id of the parent category where new categories and bookmarks should be assigned to.
     * @return void
     */
    static public function import($bookmarks, $parent_category_id = null)
    {
        $user_id = auth()->user()->id;

        foreach ($bookmarks as $category => $props)
        {
            // ignore this for now...
            if ($category === 'bookmarks' || $category === 'Other Bookmarks') continue;

            $new_category = Category::create([
                'title' => $category,
                'order' => Category::lowestOrder(null, $user_id) ?? 'a',
                'user_id' => $user_id,
                'parent_id' => $parent_category_id
            ]);

            if (key_exists('bookmarks', $props) && count($props['bookmarks']) > 0)
            {
                $bulk_bookmarks = [];
                foreach ($props['bookmarks'] as $bookmark)
                {
                    array_push($bulk_bookmarks, [
                        'name' => $bookmark['title'],
                        'url' => $bookmark['url'],
                        'category_id' => $new_category['id'],
                        'order' => $bookmark['order'],
                        'user_id' => $user_id
                    ]);
                }
                Bookmark::insert($bulk_bookmarks);
            }

            unset($props['bookmarks']);
            BookmarkManager::import($props, $new_category['id']);
        }
    }

    /**
     * Creates a JSON representation of a user's bookmarks
     *
     * @return array JSON representation of user's bookmarks.
     */
    static public function export()
    {
        return auth()
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
    }
}
