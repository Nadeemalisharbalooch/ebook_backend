<?php

use App\Http\Controllers\Api\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// Example admin routes
Route::get('/dashboard', DashboardController::class)->name('dashboard');
