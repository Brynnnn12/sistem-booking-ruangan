<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->as('dashboard.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::resource('rooms', RoomController::class);
        Route::resource('bookings', BookingController::class);
        Route::patch('bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
        Route::patch('bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
        Route::patch('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    });

require __DIR__ . '/auth.php';
