<?php

use Modules\ActivityLog\Http\Controllers\Admin\ActivityLogController;
use Modules\ActivityLog\Http\Controllers\Admin\ActivityLogSettingController;

Route::controller(ActivityLogController::class)
    ->prefix('activity-log')
    ->name('activity_log.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.activity_log.index');
        Route::get('/{id}/show', 'show')->name('show')->middleware('can:admin.activity_log.show');
    });

Route::controller(ActivityLogSettingController::class)
    ->prefix('settings')
    ->name('activity_log.')
    ->group(function () {
        Route::get('activity-logs', 'index')->name('settings.index')->middleware('can:admin.activity_log.settings');
        Route::put('activity-logs', 'update')->name('settings.update')->middleware('can:admin.activity_log.settings');
    });
