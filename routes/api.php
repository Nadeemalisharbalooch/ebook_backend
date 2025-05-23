<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

require_once base_path('routes/auth/api.php');
require_once base_path('routes/admin/api.php');
