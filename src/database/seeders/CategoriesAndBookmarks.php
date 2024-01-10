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
            'order' => 'n'
        ]);

        $docs = Category::factory()->createOne([
            'title' => 'Documentation',
            'order' => 'n'
        ]);

        $php = Category::factory()->createOne([
            'title' => 'PHP',
            'parent_id' => $docs->id,
            'order' => 'n'
        ]);

        $js = Category::factory()->createOne([
            'title' => 'JavaScript',
            'parent_id' => $docs->id,
            'order' => 'u'
        ]);

        $sec = Category::factory()->createOne([
            'title' => 'Security',
            'parent_id' => $blogs->id,
            'order' => 'n'
        ]);

        $dev = Category::factory()->createOne([
            'title' => 'Development',
            'parent_id' => $blogs->id,
            'order' => 'u'
        ]);

        $hack = Category::factory()->createOne([
            'title' => 'Hacking',
            'parent_id' => $sec->id,
            'order' => 'n'
        ]);

        Bookmark::factory()->createOne([
            'category_id' => $hack->id,
            'order' => 'n'
        ]);

        Bookmark::factory()->createOne(['category_id' => $sec->id, 'order' => 'u']);
        Bookmark::factory()->createOne(['category_id' => $sec->id, 'order' => 'x']);
        Bookmark::factory()->createOne(['category_id' => $sec->id, 'order' => 'z']);
        Bookmark::factory()->createOne(['category_id' => $dev->id, 'order' => 'n']);
        Bookmark::factory()->createOne(['category_id' => $dev->id, 'order' => 'u']);

        Bookmark::factory()->createOne(['category_id' => $blogs->id , 'order' => 'x']);
        Bookmark::factory()->createOne(['category_id' => $blogs->id , 'order' => 'z']);

        Bookmark::factory()->createOne(['category_id' => $php->id, 'name' => 'Laracasts', 'url' => 'https://laracasts.com', 'order' => 'n']);
        Bookmark::factory()->createOne(['category_id' => $php->id, 'name' => 'Laravel', 'url' => 'https://laravel.com', 'order' => 'u']);
        Bookmark::factory()->createOne(['category_id' => $js->id, 'name' => 'Vue', 'url' => 'https://vuejs.org', 'order' => 'x']);
        Bookmark::factory()->createOne(['category_id' => $js->id, 'name' => 'Vite', 'url' => 'https://vitejs.dev', 'order' => 'z']);
        Bookmark::factory()->createOne(['category_id' => $js->id, 'name' => 'Pinia', 'url' => 'https://pinia.vuejs.org', 'order' => 'zn']);
    }
}
