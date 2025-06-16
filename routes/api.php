<?php

use App\Http\Resources\Api\Admin\UserCurrentResource;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum','impersonate')->get('/user', function () {
    return new UserCurrentResource(
        auth()->user()->load('roles.permissions')
    );
});

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
