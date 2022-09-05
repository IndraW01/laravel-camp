<?php

use App\Http\Controllers\Main\DashboardController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\DashboardUserController;
use Illuminate\Support\Facades\Route;

// Main
Route::get('/', [DashboardController::class, 'index'])->name('main.dashboard');

// User Dashboard
Route::get('user/dashboard', [DashboardUserController::class, 'index'])->name('user.dashboard')->middleware(['auth', 'verified']);

// Checkout
Route::controller(CheckoutController::class)->middleware(['auth', 'verified'])->name('checkout.')->prefix('/checkout')->group(function () {
    Route::get('/success/{camp:slug}', 'success')->name('success');
    Route::get('/{camp:slug}', 'index')->name('index');
    Route::post('/{camp:slug}/store', 'store')->name('store');
});

require __DIR__ . '/auth.php';
