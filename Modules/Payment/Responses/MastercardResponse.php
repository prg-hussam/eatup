<?php

namespace Modules\Payment\Responses;

use Modules\Payment\HyperPay\HyperPayResponse;

class MastercardResponse extends HyperPayResponse
{
    /** @inheritDoc */
    public function getBrandName(): string
    {
        return "MASTER";
    }
}
