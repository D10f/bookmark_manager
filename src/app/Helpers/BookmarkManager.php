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

        foreach ($bookmarks as $key => $val)
        {
            if ($key === 'bookmarks' || $key === 'Other Bookmarks') continue;

            $new_category = Category::create([
                'title' => $key,
                'order' => Category::lowestOrder(null, $user_id) ?? 'a',
                'user_id' => $user_id,
                'parent_id' => $parent_category_id
            ]);

            if (key_exists('bookmarks', $val) && count($val['bookmarks']) > 0)
            {
                $bulk_bookmarks = [];
                foreach ($val['bookmarks'] as $bookmark)
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

            // foreach ($val as $sub_category)
            // {
            //     BookmarkManager::import($sub_category, $new_category['id']);
            // }
        }
    }
}
