<?php

use Modules\Meal\Http\Controllers\Admin\DiningPeriodController;
use Modules\Meal\Http\Controllers\Admin\IngredientController;
use Modules\Meal\Http\Controllers\Admin\MealController;
use Modules\Meal\Http\Controllers\Admin\UtilityController;

Route::controller(DiningPeriodController::class)
    ->prefix('dining_periods')
    ->name('dining_periods.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.dining_periods.index');
        Route::get('create', 'create')->name('create')->middleware('can:admin.dining_periods.create');
        Route::post('store', 'store')->name('store')->middleware('can:admin.dining_periods.create');
        Route::get('{id}/edit', 'edit')->name('edit')->middleware('can:admin.dining_periods.edit');
        Route::put('{id}/update', 'update')->name('update')->middleware('can:admin.dining_periods.edit');
        Route::delete('/{ids}', 'destroy')->name('destroy')->middleware('can:admin.dining_periods.destroy');
    });

Route::controller(IngredientController::class)
    ->prefix('ingredients')
    ->name('ingredients.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.ingredients.index');
        Route::get('create', 'create')->name('create')->middleware('can:admin.ingredients.create');
        Route::post('store', 'store')->name('store')->middleware('can:admin.ingredients.create');
        Route::get('{id}/edit', 'edit')->name('edit')->middleware('can:admin.ingredients.edit');
        Route::put('{id}/update', 'update')->name('update')->middleware('can:admin.ingredients.edit');
    });

Route::controller(MealController::class)
    ->prefix('meals')
    ->name('meals.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.meals.index');
        Route::get('create', 'create')->name('create')->middleware('can:admin.meals.create');
        Route::post('store', 'store')->name('store')->middleware('can:admin.meals.create');
        Route::get('{id}/edit', 'edit')->name('edit')->middleware('can:admin.meals.edit');
        Route::put('{id}/update', 'update')->name('update')->middleware('can:admin.meals.edit');
    });

Route::controller(UtilityController::class)
    ->prefix('utility')
    ->name('utility.')
    ->group(function () {
        Route::get('category/{id}/periods', 'getPeriodsByCategory')->name('category.periods');
    });