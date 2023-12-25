<?php

use Modules\Subscription\Http\Controllers\Admin\PlanController;

Route::controller(PlanController::class)
    ->prefix('plans')
    ->name('plans.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.plans.index');
        Route::get('create', 'create')->name('create')->middleware('can:admin.plans.create');
        Route::post('store', 'store')->name('store')->middleware('can:admin.plans.create');
        Route::get('{id}/edit', 'edit')->name('edit')->middleware('can:admin.plans.edit');
        Route::put('{id}/update', 'update')->name('update')->middleware('can:admin.plans.edit');
    });