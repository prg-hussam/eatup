<?php

namespace Modules\Payment\ClickPay;

use Modules\Payment\Contracts\HasTransactionReference;
use Modules\Payment\Contracts\ShouldRedirect;
use Modules\Payment\GatewayResponse;
use Modules\Support\Eloquent\Model;
use Clickpaysa\Laravel_package\Facades\paypage;
use Illuminate\Http\RedirectResponse;

abstract class ClickPayResponse extends GatewayResponse implements HasTransactionReference, ShouldRedirect
{
    /**
     * Instance of model
     *
     * @var \Modules\Support\Eloquent\Model
     */
    private Model $entity;

    /**
     * Extra data
     *
     * @var array
     */
    private array $data;

    public function __construct(Model $entity, array $data = [])
    {
        $this->entity = $entity;
        $this->data = $data;
    }

    /** @inheritDoc */
    public function getEntityType(): string
    {
        return get_class($this->entity);
    }

    /** @inheritDoc */
    public function getEntityId(): string|int
    {
        return $this->entity->{$this->entity->getKeyName()};
    }

    /** @inheritDoc */
    public function getEntityReferenceNo(): string
    {
        return $this->entity->getPaymentId();
    }

    /** @inheritDoc */
    public function getTransactionReference(): string
    {
        return $this->data['tranRef'];
    }

    /** @inheritDoc */
    public function getRedirectUrl(): string|RedirectResponse
    {
        return paypage::sendPaymentCode($this->data['gateway_key'])
            ->sendTransaction('sale')
            ->sendCart(
                $this->entity->getPaymentId(),
                $this->entity->total->amount(),
                $this->entity->getPaymentDescription()
            )
            ->sendCustomerDetails(
                "{$this->data['first_name']} {$this->data['last_name']}",
                $this->data['email'],
                $this->data['phone'],
                $this->data['street'],
                $this->data['city'],
                $this->data['state'],
                $this->data['country_code'],
                $this->data['zip_code'],
                request()->ip()
            )
            ->sendHideShipping(true)
            ->sendURLs(
                route('webhook.payment.clickpay.return', [
                    "payload" => encrypt(["redirect_url" => $this->entity->getPaymenReturnUrl()])
                ]),
                null
            )
            ->sendLanguage(locale())
            ->create_pay_page();
    }

    /** @inheritDoc */
    public function getMeta(): array
    {
        return [
            "signature" => $this->data["signature"],
            "token" => $this->data["token"],
            "card" => $this->data["card"],
        ];
    }
}
