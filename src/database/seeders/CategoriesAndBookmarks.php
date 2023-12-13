<?php

namespace Database\Seeders;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesAndBookmarks extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $blogs = Category::factory()->createOne([
            'title' => 'Blogs',
        ]);

        $docs = Category::factory()->createOne([
            'title' => 'Documentation',
            'order' => Category::lowestOrder(null, 1)
        ]);

        $php = Category::factory()->createOne([
            'title' => 'PHP',
            'parent_id' => $docs->id,
        ]);

        $js = Category::factory()->createOne([
            'title' => 'JavaScript',
            'parent_id' => $docs->id,
            'order' => category::lowestorder($docs->id, 1)
        ]);

        $sec = Category::factory()->createOne(['title' => 'Security', 'parent_id' => $blogs->id]);
        $dev = Category::factory()->createOne(['title' => 'Development', 'parent_id' => $blogs->id, 'order' => Category::lowestOrder($blogs->id, 1)]);

        $hack = Category::factory()->createOne(['title' => 'Hacking', 'parent_id' => $sec->id]);
        Bookmark::factory()->createOne(['category_id' => $hack->id]);

        Bookmark::factory()->createOne(['category_id' => $sec->id]);
        Bookmark::factory()->createOne(['category_id' => $sec->id]);
        Bookmark::factory()->createOne(['category_id' => $sec->id]);
        Bookmark::factory()->createOne(['category_id' => $dev->id]);
        Bookmark::factory()->createOne(['category_id' => $dev->id]);

        Bookmark::factory()->createOne(['category_id' => $blogs->id]);
        Bookmark::factory()->createOne(['category_id' => $blogs->id]);

        Bookmark::factory()->createOne(['category_id' => $php->id, 'name' => 'Laracasts', 'url' => 'https://laracasts.com']);
        Bookmark::factory()->createOne(['category_id' => $php->id, 'name' => 'Laravel', 'url' => 'https://laravel.com']);
        Bookmark::factory()->createOne(['category_id' => $js->id, 'name' => 'Vue', 'url' => 'https://vuejs.org']);
        Bookmark::factory()->createOne(['category_id' => $js->id, 'name' => 'Vite', 'url' => 'https://vitejs.dev']);
        Bookmark::factory()->createOne(['category_id' => $js->id, 'name' => 'Pinia', 'url' => 'https://pinia.vuejs.org']);
    }
}
