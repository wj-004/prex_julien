<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GifController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:api']], function () {

    Route::post('/gifs/search', [GifController::class, 'search'])->name('api.search');
    Route::get('/gifs/get-by-id/{id}', [GifController::class, 'getById'])->name('api.getById');
    Route::post('/gifs/add-bookmark', [GifController::class, 'addBookmark'])->name('api.addBookmark');

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
