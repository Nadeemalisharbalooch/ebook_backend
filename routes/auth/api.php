<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\logoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);

    // Protected routes (user must be logged in)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [logoutController::class, 'logout']);
    });
});
