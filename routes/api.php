<?php

use App\Http\Controllers\Api\UrlController;
use App\Http\Controllers\Api\AuthController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/shorten', [UrlController::class, 'create']);
    Route::get('/urls', [UrlController::class, 'index']);
    Route::get('/url/{keyword}', [UrlController::class, 'show']);
    Route::delete('/url/{keyword}', [UrlController::class, 'delete']);
});


// Registro y login
/* Route::post('/register', [AuthController::class, 'register']); */
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});