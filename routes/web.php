<?php

use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Main\DashboardController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\DashboardUserController;
use Illuminate\Support\Facades\Route;

// Main
Route::get('/', [DashboardController::class, 'index'])->name('main.dashboard');

// User Dashboard
Route::get('/user/dashboard', [DashboardUserController::class, 'index'])->name('user.dashboard')->middleware(['auth', 'verified', 'isAdmin:user']);

// Admin Route
Route::middleware(['auth', 'verified', 'isAdmin:admin'])->prefix('/admin/dashboard')->name('admin.')->group(function () {
    Route::get('/', [DashboardAdminController::class, 'index'])->name('dashboard');
    Route::resource('/discount', DiscountController::class);
});

// Midtrans routes
Route::get('/payment/success', [CheckoutController::class, 'midtransCallback']);
Route::post('/payment/success', [CheckoutController::class, 'midtransCallback']);

// Checkout
Route::controller(CheckoutController::class)->middleware(['auth', 'verified', 'isAdmin:user'])->name('checkout.')->prefix('/checkout')->group(function () {
    Route::get('/success/{camp:slug}', 'success')->name('success');
    Route::get('/{camp:slug}', 'index')->name('index');
    Route::post('/{camp:slug}/store', 'store')->name('store');

    // Route Checkout Versi 1
    // Route::get('/paid/{checkout}', 'paidAbort')->withoutMiddleware('isAdmin:user')->middleware('isAdmin:admin');
    // Route::post('/paid/{checkout}', 'paid')->name('paid')->withoutMiddleware('isAdmin:user')->middleware('isAdmin:admin');
});

require __DIR__ . '/auth.php';
