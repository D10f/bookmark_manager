<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function() {

    Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.api.store');

    Route::put('/categories/update/{category}', [CategoryController::class, 'updateApi'])->name('categories.api.update');

    Route::put('/bookmarks/update/{bookmark}', [BookmarkController::class, 'updateApi'])->name('bookmarks.api.update');

    Route::get('/categories/bookmark/{category}', [CategoryController::class, 'getBookmarks'])->name('categories.api.getBookmarks');

    Route::get('/bookmarks/export', [BookmarkController::class, 'export'])->name('bookmarks.export');
});

