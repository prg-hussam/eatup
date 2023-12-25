<?php

use Modules\User\Http\Controllers\Api\V1\Auth\RegisterController;
use Modules\User\Http\Controllers\Api\V1\Auth\LoginController;
use Modules\User\Http\Controllers\Api\V1\ProfileController;

Route::prefix('auth')
    ->group(function () {
        Route::post("login", LoginController::class)->middleware(['throttle:login']);
        Route::post('register', RegisterController::class);
    });


Route::prefix('profile')
    ->middleware("auth:customer")
    ->group(function () {
        Route::get('me', [ProfileController::class, 'me']);
        Route::put('update', [ProfileController::class, 'update']);
    });