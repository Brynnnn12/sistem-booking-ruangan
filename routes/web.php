<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ProfileController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->as('dashboard.')
    ->group(function () {

        Route::view('/', 'dashboard')->name('index');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // nanti gampang nambah
        Route::resource('rooms', RoomController::class);
        // Route::resource('bookings', BookingController::class);
    });

require __DIR__ . '/auth.php';
