<?php

use Modules\Meal\Http\Controllers\Api\V1\DiningPeriodController;
use Modules\Meal\Http\Controllers\Api\V1\IngredientController;
use Modules\Meal\Http\Controllers\Api\V1\MealController;

Route::middleware('auth:customer')
    ->group(function () {
        Route::prefix('ingredients')
            ->group(function () {
                Route::get('/', IngredientController::class);
            });
        Route::prefix('dining-periods')
            ->group(function () {
                Route::get('/', DiningPeriodController::class);
            });

        Route::get('meals/{period}/{category}', MealController::class);
    });