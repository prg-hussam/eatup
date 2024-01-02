<?php

namespace Modules\Payment\Gateways\HyperPay;

use Modules\Payment\GatewayResponse;
use Modules\Payment\HyperPay\HyperPayGateway;
use Modules\Support\Eloquent\Model;

class Mastercard extends HyperPayGateway
{
    /** @inheritDoc */
    public function getKey(): string
    {
        return "mastercard";
    }

    /** @inheritDoc */
    public function getResponse(Model $entity, array $data): GatewayResponse
    {
        return new \Modules\Payment\Responses\MastercardResponse($entity, $data);
    }
}
