<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Роуты для AuthController
Route::prefix('auth')->middleware('api')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])
        ->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])
        ->name('auth.register');
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('auth.logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])
        ->name('auth.refresh');
});

// Роуты для PostController
Route::prefix('post')->middleware('api')->group(function () {
    Route::get('/{id}', [PostController::class, 'show'])
        ->name('post.show');
    Route::post('/', [PostController::class, 'store'])
        ->name('post.store');
    Route::patch('/{id}', [PostController::class, 'update'])
        ->name('post.update');
    Route::delete('/{id}', [PostController::class, 'destroy'])
        ->name('post.destroy');
});
