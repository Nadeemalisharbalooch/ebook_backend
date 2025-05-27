<?php

use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\ProfileController;
use App\Http\Controllers\Api\Admin\RoleController;
use Illuminate\Support\Facades\Route;

// Example admin routes
Route::get('dashboard', DashboardController::class)->name('dashboard');

Route::get('profile', [ProfileController::class, 'view'])->name('profile');
Route::post('profile', [ProfileController::class, 'store'])->name('profile');

// Example admin routes for roles
Route::get('roles', [RoleController::class, 'index']); // List all active roles
Route::post('roles', [RoleController::class, 'store']); // Create role
Route::put('roles/{id}', [RoleController::class, 'update'])->name('roles.update'); // Update role
Route::delete('roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy'); // Soft delete role

//  Soft Delete Features
Route::get('roles/trashed', [RoleController::class, 'trashed'])->name('roles.trashed'); // List only trashed roles
Route::post('roles/{id}/restore', [RoleController::class, 'restore'])->name('roles.restore'); // Restore soft deleted role
Route::delete('roles/{id}/force', [RoleController::class, 'forceDelete'])->name('roles.forceDelete'); // Permanently delete role
