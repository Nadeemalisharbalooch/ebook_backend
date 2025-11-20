<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::apiResource('books',FrontendController::class);
