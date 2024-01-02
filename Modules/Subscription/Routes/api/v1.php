<?php

use Modules\Subscription\Http\Controllers\Api\V1\PlanController;
use Modules\Subscription\Http\Controllers\Api\V1\SubscribeController;

Route::middleware('auth:customer')
    ->group(function () {
        Route::get('plans', PlanController::class);

        Route::post('subscribe', [SubscribeController::class, 'subscribe']);
    });