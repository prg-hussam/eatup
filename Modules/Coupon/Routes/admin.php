<?php

use Modules\Coupon\Http\Controllers\Admin\CouponController;

Route::controller(CouponController::class)
    ->prefix('coupons')
    ->name('coupons.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.coupons.index');
        Route::get('create', 'create')->name('create')->middleware('can:admin.coupons.create');
        Route::post('/', 'store')->name('store')->middleware('can:admin.coupons.create');
        Route::get('{id}/edit', 'edit')->name('edit')->middleware('can:admin.coupons.edit');
        Route::put('{id}/update', 'update')->name('update')->middleware('can:admin.coupons.edit');
        Route::delete('{ids?}', 'destroy')->name('destroy')->middleware('can:admin.coupons.destroy');
    });