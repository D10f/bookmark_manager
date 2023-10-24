<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookmarkController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function() {
    return Inertia::render('Welcome', [
        'bookmarks_index' => route('bookmarks.index')
    ]);
});

/*
|--------------------------------------------------------------------------
| Bookmark Routes
|--------------------------------------------------------------------------
*/
Route::get('/app', [BookmarkController::class, 'index'])->name('bookmarks.index');
Route::get('/app/bookmarks/create', [BookmarkController::class, 'create'])->name('bookmarks.create');
Route::get('/app/bookmarks/{bookmark}/edit', [BookmarkController::class, 'edit'])->name('bookmarks.edit');
Route::post('/app/bookmarks/create', [BookmarkController::class, 'store'])->name('bookmarks.store');

