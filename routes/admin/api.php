<?php

use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

// Example admin routes
Route::get('dashboard', DashboardController::class)->name('dashboard');

Route::get('profile', [ProfileController::class, 'view'])->name('profile');
Route::post('profile', [ProfileController::class, 'store'])->name('profile');
