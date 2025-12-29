<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Landing page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

/*
|--------------------------------------------------------------------------
| Authenticated area
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    /*
    | Dashboard (post-login)
    | Dados vêm do HandleInertiaRequests
    */
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    /*
    | Rooms
    */
    Route::get('/rooms', [RoomController::class, 'index'])
        ->name('rooms.index');

    Route::post('/rooms', [RoomController::class, 'store'])
        ->name('rooms.store');

    Route::get('/rooms/{room}', [RoomController::class, 'show'])
        ->name('rooms.show');

    /*
    | Messages
    */
    Route::post('/rooms/{room}/messages', [MessageController::class, 'store'])
        ->name('rooms.messages.store');

    /*
    | Room management
    */
    Route::patch('/rooms/{room}/rename', [RoomController::class, 'rename'])
        ->name('rooms.rename');

    Route::post('/rooms/{room}/invite', [RoomController::class, 'invite'])
        ->name('rooms.invite');

    Route::post('/rooms/{room}/users/{user}/toggle-admin', [RoomController::class, 'toggleAdmin'])
        ->name('rooms.users.toggleAdmin');

    Route::delete('/rooms/{room}/users/{user}', [RoomController::class, 'removeUser'])
        ->name('rooms.users.remove');

        Route::put('/user/status', [ProfileController::class, 'updateStatus'])
    ->name('profile.update-status');
});
