<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function () {
    $user = auth()->user();

    return response()->json([
        'user' => $user,
        'roles' => $user->getRoleNames(), // returns a Collection
        'permissions' => $user->getAllPermissions()->pluck('name'),
    ]);
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
