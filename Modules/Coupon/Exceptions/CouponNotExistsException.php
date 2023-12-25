<?php

namespace Modules\Coupon\Exceptions;

use Exception;
use Modules\Support\Http\ApiResponse;

class CouponNotExistsException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return ApiResponse::errors(null, __('messages.not_exists'), 403);
    }
}
