<?php

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Modules\User\Http\Controllers\Admin\LockScreenController;
use Modules\User\Http\Controllers\Admin\RoleController;
use Modules\User\Http\Controllers\Admin\UserController;
use Modules\User\Http\Controllers\Admin\UserResetPasswordController;

Route::prefix('my-account')
    ->name('my_account.')
    ->group(function () {
        Route::get('/', 'MyAccountController@index')->name('index');
        Route::put('/ui-options', 'MyAccountController@storeUiOptions')->name('ui_options');
    });

// Lock Screen
Route::controller(LockScreenController::class)
    ->prefix('lock-screen')
    ->name('users.lock_screen.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->withoutMiddleware(['lockScreen']);
        Route::put('/lock', 'lock')->name('lock');
        Route::put('/unlock', 'unlock')->name('unlock')->withoutMiddleware(['lockScreen']);
    });

// Users
Route::controller(UserController::class)
    ->prefix('users')
    ->name('users.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.users.index');
        Route::get('/create', 'create')->name('create')->middleware('can:admin.users.create');
        Route::post('/', 'store')->name('store')->middleware('can:admin.users.create');
        Route::get('/{id}/edit', 'edit')->name('edit')->middleware('can:admin.users.edit');
        Route::put('/{id}/edit', 'update')->name('update')->middleware('can:admin.users.edit');
        Route::delete('/{ids}', 'destroy')->name('destroy')->middleware('can:admin.users.destroy');
    });

Route::post('/users/reset-password', UserResetPasswordController::class)
    ->name('users.reset_password')
    ->middleware('can:admin.users.edit');

// Roles
Route::controller(RoleController::class)
    ->prefix('roles')
    ->name('roles.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:admin.roles.index');
        Route::get('/create', 'create')->name('create')->middleware('can:admin.roles.create');
        Route::post('/', 'store')->name('store')->middleware('can:admin.roles.create');
        Route::get('/{id}/edit', 'edit')->name('edit')->middleware('can:admin.roles.edit');
        Route::put('/{id}/edit', 'update')->name('update')->middleware('can:admin.roles.edit');
        Route::delete('/{ids}', 'destroy')->name('destroy')->middleware('can:admin.roles.destroy');
    });
