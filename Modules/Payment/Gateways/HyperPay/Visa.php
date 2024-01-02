<?php

namespace Modules\Payment\Gateways\HyperPay;

use Modules\Payment\GatewayResponse;
use Modules\Payment\HyperPay\HyperPayGateway;
use Modules\Support\Eloquent\Model;

class Visa extends HyperPayGateway
{
    /** @inheritDoc */
    public function getKey(): string
    {
        return "visa";
    }

    /** @inheritDoc */
    public function getResponse(Model $entity, array $data): GatewayResponse
    {
        return new \Modules\Payment\Responses\VisaResponse($entity, $data);
    }
}
