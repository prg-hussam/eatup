<?php

namespace Modules\Payment\Gateways\ClickPay;

use Modules\Payment\ClickPay\ClickPayGateway;
use Modules\Payment\GatewayResponse;
use Modules\Support\Eloquent\Model;

class Mada extends ClickPayGateway
{
    /** @inheritDoc */
    public function getKey(): string
    {
        return "mada";
    }

    /** @inheritDoc */
    public function getResponse(Model $entity, array $data): GatewayResponse
    {
        return new \Modules\Payment\Responses\ClickPay\MadaResponse($entity, $data);
    }
}
