<?php

use App\Http\Controllers\Main\DashboardController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard', 301);

// Main
Route::get('/dashboard', [DashboardController::class, 'index'])->name('main.dashboard');

require __DIR__.'/auth.php';
