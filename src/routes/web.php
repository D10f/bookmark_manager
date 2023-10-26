<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\Auth\LoginController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Landing Page and other static routes
|--------------------------------------------------------------------------
*/

Route::get('/', function() {
    return Inertia::render('Welcome', [
        'bookmarks_index' => route('bookmarks.index')
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
Route::post('/logout', [LoginController::class, 'destroy'])->name('auth.destroy');

Route::middleware('auth')->group(function() {

    /*
    |--------------------------------------------------------------------------
    | Bookmark routes
    |--------------------------------------------------------------------------
    */
    Route::get('/app', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::get('/app/bookmarks/create', [BookmarkController::class, 'create'])->name('bookmarks.create');
    Route::get('/app/bookmarks/{bookmark}/edit', [BookmarkController::class, 'edit'])->name('bookmarks.edit');
    Route::post('/app/bookmarks/create', [BookmarkController::class, 'store'])->name('bookmarks.store');

});

