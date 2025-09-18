<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CertificateController;

Route::prefix('api')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware('jwt')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);

        Route::prefix('certificates')->group(function () {
            Route::get('/', [CertificateController::class, 'index']);
            Route::post('/', [CertificateController::class, 'store']);
            Route::get('/{id}', [CertificateController::class, 'show']);
            Route::put('/{id}', [CertificateController::class, 'update']);
            Route::delete('/{id}', [CertificateController::class, 'destroy']);
        });

        Route::get('/toggle-state', [SettingsController::class, 'getToggleState']);
        Route::post('/toggle-state', [SettingsController::class, 'updateToggleState']);
    });
});
