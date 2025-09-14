<?php

use App\Http\Controllers\Api\Admin\BookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
*/

// Dashboard route
Route::apiResource('books', BookController::class);
Route::post('/books/{book}', [BookController::class, 'update']);

Route::prefix('books')->group(function () {
    Route::get('trashed', [BookController::class, 'trashed'])->name('books.trashed');
    Route::post('{book}/restore', [BookController::class, 'restore'])->name('books.restore');
    Route::delete('{book}/force-delete', [BookController::class, 'forceDelete'])->name('books.forceDelete');
    Route::patch('/{book}/toggle-active', [BookController::class, 'toggleActive']);
});
