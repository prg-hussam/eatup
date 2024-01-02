<?php

namespace Modules\Payment\HyperPay;

use Illuminate\Http\Request;
use Modules\Payment\Contracts\InvoiceGatewayInterface;
use Modules\Payment\Contracts\RechargeBalanceGatewayInterface;
use Modules\Payment\Contracts\ShipmentGatewayInterface;
use Modules\Payment\Contracts\SubscriptionGatewayInterface;
use Modules\Payment\Facades\HyperPay;
use Modules\Payment\GatewayResponse;
use Modules\Support\Eloquent\Model;
use Modules\Payment\Gateway;

abstract class HyperPayGateway extends Gateway implements
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
        $this->label = setting("{$this->key}_label");
        $this->description = setting("{$this->key}_description");
        $this->logo = getMedia(setting("{$this->key}_logo"))?->url;
    }

    /** @inheritDoc */
    public function purchase(Request $request, Model $entity): GatewayResponse
    {
        $billingAddress = auth('customer')->user()->billing_address;
        return $this->getResponse(
            $entity,
            HyperPay::checkouts(
                merchantTransactionId: $entity->getPaymentId(),
                paymentMethod: $this->key,
                total: $entity->total,
                customerEmail: $billingAddress['email'],
                customerGivenName: $billingAddress['first_name'],
                customerSurname: $billingAddress['last_name'],
                customerPhone: $billingAddress['phone'],
                billingStreet: $billingAddress['street'],
                billingCity: $billingAddress['city'],
                billingState: $billingAddress['state'],
                billingPostCode: $billingAddress['zip_code'],
                billingCountry: $billingAddress['country_code'],
            )
        );
    }

    /** @inheritDoc */
    public function complete(Request $request, Model $entity): GatewayResponse
    {
        return $this->getResponse($entity, HyperPay::resourcePath(
            paymentMethod: $this->key,
            resourcePath: $request->resourcePath
        ));
    }
}
