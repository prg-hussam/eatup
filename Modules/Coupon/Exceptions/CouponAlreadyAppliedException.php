<?php

namespace Modules\Coupon\Exceptions;

use Exception;
use Modules\Support\Http\ApiResponse;

class CouponAlreadyAppliedException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return ApiResponse::errors(null, __('messages.already_applied'), 403);
    }
}
