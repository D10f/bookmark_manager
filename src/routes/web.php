<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use Doctrine\DBAL\Query\QueryBuilder;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Landing Page and other static routes
|--------------------------------------------------------------------------
*/

Route::get('/', function() {
    return Inertia::render('Welcome', [
        'home_url' => route('home')
    ]);
});

/*
|--------------------------------------------------------------------------
| Authencation routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::get('/register', [LoginController::class, 'create'])->name('auth.register');
Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
Route::post('/register', [LoginController::class, 'store'])->name('auth.store');
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('auth.destroy');

Route::middleware('auth')->prefix('app')->group(function() {

    /*
    |--------------------------------------------------------------------------
    | Home route
    |--------------------------------------------------------------------------
    */
    Route::get('/', function() {
        // TODO: Get only top-level categories
        // ->where('parent_id', '=', null)
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
    })->name('home');

    /*
    |--------------------------------------------------------------------------
    | Category routes
    |--------------------------------------------------------------------------
    */
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}/delete', [CategoryController::class, 'delete'])->name('categories.delete');

    /*
    |--------------------------------------------------------------------------
    | Bookmark routes
    |--------------------------------------------------------------------------
    */
    Route::get('/bookmarks/create', [BookmarkController::class, 'create'])->name('bookmarks.create');
    Route::get('/bookmarks/{bookmark}/edit', [BookmarkController::class, 'edit'])->name('bookmarks.edit');
    Route::post('/bookmarks/create', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::post('/bookmarks/{bookmark}/update', [BookmarkController::class, 'update'])->name('bookmarks.update');
    Route::delete('/bookmarks/{bookmark}/delete', [BookmarkController::class, 'delete'])->name('bookmarks.delete');

    /*
    |--------------------------------------------------------------------------
    | Profile routes
    |--------------------------------------------------------------------------
    */
    // Route::get('/app/profile/{profile}', [UserController::class, 'show'])->name('user.show');


    /*
    |--------------------------------------------------------------------------
    | Settings routes
    |--------------------------------------------------------------------------
    */
    // Route::get('/app/settings/{profile}', [SettingsController::class, 'show'])->name('settings.show');
});

