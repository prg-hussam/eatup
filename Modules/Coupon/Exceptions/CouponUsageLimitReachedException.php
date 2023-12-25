<?php

namespace Modules\Coupon\Exceptions;

use Exception;
use Modules\Support\Http\ApiResponse;

class CouponUsageLimitReachedException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return ApiResponse::errors(null, __('messages.usage_limit_reached'), 403);
    }
}
