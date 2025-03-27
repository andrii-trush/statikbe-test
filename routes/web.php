<?php

declare(strict_types=1);

use App\Http\Controllers\BookingController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookingController::class, 'index'])->name('index');
Route::get('statistic', StatisticController::class)->name('statistic');
Route::prefix('booking')->as('booking.')->group(
    function () {
        Route::post('', [BookingController::class, 'store'])->name('store');
        Route::get('success', [BookingController::class, 'success'])->name('success');
        Route::get('{booking:booking_ref}', [BookingController::class, 'show'])->name('show');
    }
);

//
//
// Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
//
// Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
//
// require __DIR__.'/auth.php';
