<?php

use Modules\Category\Http\Controllers\Api\V1\CategoryController;


Route::middleware('auth:customer')
    ->group(function () {
        Route::get('dining-period/{dining_period}/categories', [CategoryController::class, 'getCategoriesByPeriod']);
    });