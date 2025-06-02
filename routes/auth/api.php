<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class)->name('login');

Route::post('register', RegisterController::class)->name('register');

Route::post('forgot-password', ForgotPasswordController::class)->name('forgot-password');

Route::post('reset-password', ResetPasswordController::class)->name('reset-password');

Route::get('verify', function () {
    return 'verification';
})->name('verification');

Route::post('logout', LogoutController::class)->name('logout')->middleware('auth:sanctum');
