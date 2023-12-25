<?php

use Modules\Localization\Http\Controllers\Admin\CityController;
use Modules\Localization\Http\Controllers\Admin\ProvinceController;

Route::controller(ProvinceController::class)
    ->prefix('provinces')
    ->name('provinces.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.provinces.index');
        Route::get('create', 'create')->name('create')->middleware('can:admin.provinces.create');
        Route::post('store', 'store')->name('store')->middleware('can:admin.provinces.create');
        Route::get('{id}/edit', 'edit')->name('edit')->middleware('can:admin.provinces.edit');
        Route::put('{id}/update', 'update')->name('update')->middleware('can:admin.provinces.edit');
    });

Route::controller(CityController::class)
    ->prefix('cities')
    ->name('cities.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.cities.index');
        Route::get('create', 'create')->name('create')->middleware('can:admin.cities.create');
        Route::post('store', 'store')->name('store')->middleware('can:admin.cities.create');
        Route::get('{id}/edit', 'edit')->name('edit')->middleware('can:admin.cities.edit');
        Route::put('{id}/update', 'update')->name('update')->middleware('can:admin.cities.edit');
    });