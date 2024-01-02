<?php

namespace Modules\Payment\Gateways\ClickPay;

use Modules\Payment\ClickPay\ClickPayGateway;
use Modules\Payment\GatewayResponse;
use Modules\Support\Eloquent\Model;

class CreditCard extends ClickPayGateway
{
    /** @inheritDoc */
    public function getKey(): string
    {
        return "creditcard";
    }

    /** @inheritDoc */
    public function getResponse(Model $entity, array $data): GatewayResponse
    {
        return new \Modules\Payment\Responses\ClickPay\CreditCardResponse($entity, $data);
    }
}
