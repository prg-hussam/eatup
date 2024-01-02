<?php

use Modules\Payment\Http\Controllers\Portal\PaymentController;

Route::get('/payment/{payload}', [PaymentController::class, "index"])->name('payment.index');
