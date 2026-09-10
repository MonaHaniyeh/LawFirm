<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CaseController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MessageController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])
    ->name('api.login');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('api.logout');

    Route::apiResource('cases', CaseController::class);

    Route::apiResource('users', UserController::class);

    Route::apiResource('appointments', AppointmentController::class);

    Route::apiResource('cases.messages', MessageController::class);
});
