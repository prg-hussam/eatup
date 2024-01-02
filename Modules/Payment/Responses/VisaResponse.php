<?php

namespace Modules\Payment\Responses;

use Modules\Payment\HyperPay\HyperPayResponse;

class VisaResponse extends HyperPayResponse
{
    /** @inheritDoc */
    public function getBrandName(): string
    {
        return "VISA";
    }
}
