<?php

use Modules\Category\Http\Controllers\Admin\CategoryController;

Route::controller(CategoryController::class)
    ->prefix('categories')
    ->name('categories.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.categories.index');
        Route::get('create', 'create')->name('create')->middleware('can:admin.categories.create');
        Route::post('store', 'store')->name('store')->middleware('can:admin.categories.create');
        Route::get('{id}/edit', 'edit')->name('edit')->middleware('can:admin.categories.edit');
        Route::put('{id}/update', 'update')->name('update')->middleware('can:admin.categories.edit');
    });