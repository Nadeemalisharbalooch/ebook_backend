<?php

use App\Http\Controllers\Api\Admin\AccountStatusController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\EmailBuilder\EmailTemplateController;
use App\Http\Controllers\Api\Admin\EmailBuilder\GlobalEmailTemplateController;
use App\Http\Controllers\Api\Admin\ImpersonationController;
use App\Http\Controllers\Api\Admin\ProfileController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\StaffUserController;
use App\Http\Controllers\Api\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
*/

// Dashboard route
Route::get('dashboard', DashboardController::class)->name('dashboard');

// Profile routes
Route::get('profile', [ProfileController::class, 'view'])->name('profile');
Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
Route::put('profile/password', [ProfileController::class, 'updatePassword']);

// Role routes
Route::prefix('roles')->group(function () {
    Route::get('trashed', [RoleController::class, 'trashed'])->name('roles.trashed');
    Route::post('{id}/restore', [RoleController::class, 'restore'])->name('roles.restore');
    Route::delete('{role}/force', [RoleController::class, 'forceDelete'])->name('roles.forceDelete');
});
Route::apiResource('roles', RoleController::class)->except(['show']);

// User routes
Route::prefix('users')->group(function () {
    Route::get('trashed', [UserController::class, 'trashed'])->name('users.trashed');
    Route::post('{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('{user}/force', [UserController::class, 'forceDelete'])->name('users.forceDelete');
    Route::get('{user}/active', [UserController::class, 'activeUsers'])->name('users.active');
});
Route::apiResource('users', UserController::class);

// Account status toggles
Route::patch('/{user}/toggle-active', [AccountStatusController::class, 'toggleActive']);
Route::patch('/{user}/toggle-locked', [AccountStatusController::class, 'toggleLocked']);
Route::patch('/{user}/toggle-suspended', [AccountStatusController::class, 'toggleSuspended']);

// Staff routes
Route::apiResource('staff', StaffUserController::class);
Route::prefix('staff')->group(function () {
    Route::get('trashed', [StaffUserController::class, 'trashed'])->name('staff.trashed');
    Route::post('{user}/restore', [StaffUserController::class, 'restore'])->name('staff.restore');
    Route::delete('{user}/force', [StaffUserController::class, 'forceDelete'])->name('staff.forceDelete');
});

// Global Email Templates
Route::apiResource('global-email-templates', GlobalEmailTemplateController::class);

// Email Templates
Route::apiResource('email-templates', EmailTemplateController::class);

// Impersonation routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/impersonate/{user}', [ImpersonationController::class, 'impersonate'])->name('impersonate.start');
    Route::get('/impersonate/stop', [ImpersonationController::class, 'stopImpersonate'])->name('impersonate.stop');
});
