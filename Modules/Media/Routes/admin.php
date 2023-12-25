<?php

use Illuminate\Support\Facades\Route;
use Modules\Media\Http\Controllers\Admin\FileManagerController;
use Modules\Media\Http\Controllers\Admin\MediaController;

Route::controller(MediaController::class)
    ->prefix('media')
    ->name('media.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.media.index');
        Route::post('/', 'store')->name('store')->middleware('can:admin.media.create');
        Route::post('/folder/store', 'storeFolder')->name('folder.store')->middleware('can:admin.media.create');
        Route::delete('{ids}/destroy', 'destroy')->name('destroy')->middleware('can:admin.media.destroy');
        Route::put('{id}/update', 'update')->name('update')->middleware('can:admin.media.create');
    });

Route::get('file-manager', FileManagerController::class)->name('file_manager.index')->middleware('can:admin.media.index');
