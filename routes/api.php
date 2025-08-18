<?php

use App\Http\Controllers\Api\Admin\ProfileController;
use App\Http\Controllers\Api\General\LocationController;
use App\Http\Resources\Api\Admin\UserCurrentResource;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum', 'impersonate')->get('/user', function () {
    return new UserCurrentResource(
        auth()->user()->load('roles.permissions')
    );
});

Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
Route::put('profile/password', [ProfileController::class, 'updatePassword']);
// Auth Routes
Route::prefix('auth')->name('auth.')->group(function () {
    require __DIR__.'/auth/api.php';
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['isAdmin', 'auth:sanctum'])->group(function () {
    require __DIR__.'/admin/api.php';
});

// Client/User Routes
Route::prefix('user')->name('user.')->middleware(['isUser', 'auth:sanctum'])->group(function () {
    require __DIR__.'/user/api.php';
});

Route::apiResource('countries', LocationController::class);

Route::get('/states/{country}', [LocationController::class, 'states']);

Route::get('/cities/{state}', [LocationController::class, 'cities']);
