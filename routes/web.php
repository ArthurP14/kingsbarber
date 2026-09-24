<?php

use App\Http\Controllers\BarberController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', [BarberController::class, 'index'])->name('home');

// JSON API consumed by the frontend
Route::prefix('api')->group(function () {
    Route::get('/services',     [BarberController::class, 'services'])->name('api.services');
    Route::get('/barbers',      [BarberController::class, 'barbers'])->name('api.barbers');
    Route::get('/hours',        [BarberController::class, 'hours'])->name('api.hours');
    Route::get('/status',       [BarberController::class, 'status'])->name('api.status');

    Route::get('/availability', [BookingController::class, 'availability'])->name('api.availability');
    Route::post('/bookings',    [BookingController::class, 'store'])->name('api.bookings');
});
