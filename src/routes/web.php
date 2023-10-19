<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return Inertia::render('bookmarks/Index');
});

// Route::get('/login', [LoginController::class, 'create'])->name('login');
// Route::post('/login', [LoginController::class, 'store']);
// Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth');

// Route::middleware('auth')->group(function () {

//     Route::get('/', function () {
//         return Inertia::render('Home');
//     });

//     Route::get('/users', [UserController::class, 'index']);
//     Route::get('/users/{user}/edit', [UserController::class, 'edit'])->can('edit', 'user');
//     Route::put('/users/{user}', [UserController::class, 'update']);
//     Route::post('/users', [UserController::class, 'store']);
//     Route::get('/users/create', [UserController::class, 'create'])->can('create', User::class);

//     Route::get('/settings', function () {
//         return Inertia::render('Settings');
//     });


// });

