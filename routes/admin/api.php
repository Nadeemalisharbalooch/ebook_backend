<?php

use App\Http\Controllers\API\Admin\PermissionController;
use App\Http\Controllers\API\Admin\RoleController;
use App\Http\Controllers\API\Admin\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::apiResource('permissions', PermissionController::class);
Route::apiResource('roles', RoleController::class);

Route::post('/users/{id}/assign-role', [UserRoleController::class, 'assignRole']);
Route::post('/users/{id}/remove-role', [UserRoleController::class, 'removeRole']);
Route::post('/users/{id}/sync-roles', [UserRoleController::class, 'syncRoles']);
