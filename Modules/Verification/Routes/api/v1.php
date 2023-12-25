<?php

use Modules\Verification\Http\Controllers\Api\V1\VerificationController;

Route::prefix("verifications")
    ->controller(VerificationController::class)
    ->group(function () {
        Route::post("verify", "verify");
    });