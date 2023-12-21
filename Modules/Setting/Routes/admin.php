<?php

use Modules\Setting\Http\Controllers\Admin\SettingController;

Route::controller(SettingController::class)
    ->prefix('settings')
    ->name('settings.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.settings.index');
        Route::get('/edit', 'edit')->name('edit')->middleware('can:admin.settings.edit');
        Route::put('/update', 'update')->name('update')->middleware('can:admin.settings.edit');
    });
