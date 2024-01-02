<?php

use Modules\Slider\Http\Controllers\Admin\SliderController;

Route::controller(SliderController::class)
    ->prefix('sliders')
    ->name('sliders.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.sliders.index');
        Route::get('/create', 'create')->name('create')->middleware('can:admin.sliders.create');
        Route::post('/', 'store')->name('store')->middleware('can:admin.sliders.create');
        Route::get('/{id}/edit', 'edit')->name('edit')->middleware('can:admin.sliders.edit');
        Route::put('/{id}/edit', 'update')->name('update')->middleware('can:admin.sliders.edit');
        Route::delete('/{ids}', 'destroy')->name('destroy')->middleware('can:admin.sliders.destroy');
    });
