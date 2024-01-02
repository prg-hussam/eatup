<?php

use Modules\Payment\Http\Controllers\Platform\PaymentSettingsController;

Route::controller(PaymentSettingsController::class)
    ->prefix('settings/payments')
    ->name('platform.payments.settings.')
    ->middleware('can:platform.payments.settings')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/update', 'update')->name('update');
    });
