<?php

use App\Http\Controllers\Api\User\DashboardController;
use Illuminate\Support\Facades\Route;

// Example user routes
Route::get('dashboard', DashboardController::class)->name('dashboard');
