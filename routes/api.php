<?php

use App\Http\Controllers\Api\Admin\ProfileController;
use App\Http\Controllers\Api\General\LocationController;
use App\Http\Resources\Api\Admin\UserCurrentResource;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:sanctum', 'impersonate'])->get('/user', function () {
    $user = auth()->user()->load('roles.permissions');

    $resource = new UserCurrentResource($user);

    return ResponseService::success(
        $resource,
        'User fetched successfully'
    );
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [ProfileController::class, 'view'])->name('profile');
    Route::post('me', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('me', [ProfileController::class, 'destroy']);
    Route::put('me/change-password', [ProfileController::class, 'updatePassword']);
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

Route::prefix('vendor')->name('vendor.')->middleware(['isAdmin', 'auth:sanctum'])->group(function () {
    require __DIR__.'/vendor/api.php';
});

  require __DIR__.'/frontend/api.php';
Route::apiResource('countries', LocationController::class);

Route::get('/states/{country}', [LocationController::class, 'states']);

Route::get('/cities/{state}', [LocationController::class, 'cities']);
