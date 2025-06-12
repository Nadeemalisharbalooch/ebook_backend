<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();

    // Add custom attributes without overwriting relationships
    $user->setAttribute('role_names', $user->getRoleNames());
    $user->setAttribute('permissions', $user->getAllPermissions()->pluck('name'));

    return $user; // This returns an object (Eloquent model + added attributes)
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
