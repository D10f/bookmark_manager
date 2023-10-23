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
    return Inertia::render('Welcome');
});
Route::get('/app', [BookmarkController::class, 'index']);
Route::get('/app/create', [BookmarkController::class, 'create']);
Route::get('/app/edit/{id}/edit', [BookmarkController::class, 'edit']);

