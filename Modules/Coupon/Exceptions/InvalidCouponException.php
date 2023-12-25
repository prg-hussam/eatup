<?php

namespace Modules\Coupon\Exceptions;

use Exception;
use Modules\Support\Http\ApiResponse;

class InvalidCouponException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return ApiResponse::errors(null, __('messages.invalid_coupon'), 403);
    }
}
