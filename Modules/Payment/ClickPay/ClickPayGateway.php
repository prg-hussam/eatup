<?php

namespace Modules\Payment\ClickPay;

use Illuminate\Http\Request;
use Modules\Payment\Contracts\InvoiceGatewayInterface;
use Modules\Payment\Contracts\RechargeBalanceGatewayInterface;
use Modules\Payment\Contracts\ShipmentGatewayInterface;
use Modules\Payment\Contracts\SubscriptionGatewayInterface;
use Modules\Payment\GatewayResponse;
use Modules\Support\Eloquent\Model;
use Modules\Payment\Gateway;
use Clickpaysa\Laravel_package\Facades\paypage;

abstract class ClickPayGateway extends Gateway implements
    ShipmentGatewayInterface,
    SubscriptionGatewayInterface,
    InvoiceGatewayInterface,
    RechargeBalanceGatewayInterface
{
    /**
     * Gateway Key
     *
     * @var string
     */
    protected string $key;

    /**
     * Get Gateway key
     *
     * @return string
     */
    abstract protected function getKey(): string;

    /**
     * Get Response
     *
     * @param \Modules\Support\Eloquent\Model $entity
     * @param array $data
     * @return \Modules\Payment\GatewayResponse
     */
    abstract protected function getResponse(Model $entity, array $data): GatewayResponse;

    public function __construct()
    {
        $this->key = $this->getKey();
        $this->label = setting("{$this->key}_label", "");
        $this->description = setting("{$this->key}_description", "");
        $this->logo = getMedia(setting("{$this->key}_logo"))?->url;
    }

    /** @inheritDoc */
    public function purchase(Request $request, Model $entity): GatewayResponse
    {
        return $this->getResponse(
            $entity,
            [
                ...auth('customer')->user()->billing_address,
                "gateway_key" => $this->getKey()
            ]
        );
    }

    /** @inheritDoc */
    public function complete(Request $request, Model $entity): GatewayResponse
    {
        $payment = paypage::queryTransaction($request->tranRef);

        if (
            !is_null($payment->reference_no) &&
            $payment->reference_no == $entity->getPaymentId() &&
            $payment->payment_result->response_status == "A"
        ) {
            return $this->getResponse($entity, [
                "signature" => $request->signature,
                "token" => $request->token,
                "tranRef" => $request->tranRef,
                "card" => [
                    "holder" => $payment->customer_details->name,
                    "payment_description" => $payment->payment_info->payment_description,
                    "payment_method" => $payment->payment_info->payment_method,
                    "expiry_month" => $payment->payment_info->expiryMonth,
                    "expiry_year" => $payment->payment_info->expiryYear,
                ]
            ]);
        }

        throw new \Exception(__("messages.payment_fail"));
    }
}
