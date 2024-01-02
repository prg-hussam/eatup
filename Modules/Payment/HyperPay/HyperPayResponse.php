<?php

namespace Modules\Payment\HyperPay;

use Modules\Payment\Contracts\HasTransactionReference;
use Modules\Payment\Contracts\ShouldRedirect;
use Modules\Payment\GatewayResponse;
use Modules\Support\Eloquent\Model;

abstract class HyperPayResponse extends GatewayResponse implements HasTransactionReference, ShouldRedirect
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

    /**
     * Get brand name
     *
     * @return string
     */
    abstract public function getBrandName(): string;

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
        return $this->data['id'];
    }

    /** @inheritDoc */
    public function getRedirectUrl(): string
    {
        return route('portal.payment.index', encrypt([
            "ndc" => $this->data['ndc'],
            "brand" => $this->getBrandName(),
            "shopperResultUrl" => $this->entity->getPaymenReturnUrl(),
            "url" => $this->data['url'],
        ]));
    }

    /** @inheritDoc */
    public function getMeta(): array
    {
        return [
            "card" => $this->data["card"] ?? null
        ];
    }
}
