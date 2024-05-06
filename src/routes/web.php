<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Landing Page and other static routes
|--------------------------------------------------------------------------
*/

Route::get('/', function() {
    return Inertia::render('Welcome');
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

/*
|--------------------------------------------------------------------------
| Password reset routes
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', [LoginController::class, 'passwordResetShow'])->name('password.index');
Route::get('/forgot-password/{token}', [LoginController::class, 'passwordResetForm'])->name('password.reset');
Route::post('/forgot-password', [LoginController::class, 'passwordResetEmail'])->name('password.email');
Route::post('/password-reset', [LoginController::class, 'passwordResetUpdate'])->name('password.update');

Route::middleware('auth')->prefix('app')->group(function() {

    /*
    |--------------------------------------------------------------------------
    | Bookmark routes
    |--------------------------------------------------------------------------
    */
    Route::get('/', [BookmarkController::class, 'index'])->name('home');
    Route::get('/bookmarks/create', [BookmarkController::class, 'create'])->name('bookmarks.create');
    Route::get('/bookmarks/{bookmark}/edit', [BookmarkController::class, 'edit'])->name('bookmarks.edit');
    Route::post('/bookmarks/create', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::post('/bookmarks/{bookmark}/update', [BookmarkController::class, 'update'])->name('bookmarks.update');
    Route::post('/bookmarks/import', [BookmarkController::class, 'importBookmarks'])->name('bookmarks.import');
    Route::delete('/bookmarks/{bookmark}/delete', [BookmarkController::class, 'delete'])->name('bookmarks.delete');

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
    | Profile routes
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [UserController::class, 'index'])->name('profile.me');
    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [UserController::class, 'delete'])->name('profile.delete');

    /*
    |--------------------------------------------------------------------------
    | Settings routes
    |--------------------------------------------------------------------------
    */
    // Route::get('/app/settings/{profile}', [SettingsController::class, 'show'])->name('settings.show');
});

