<?php

namespace Modules\Payment\Responses;

use Modules\Payment\GatewayResponse;
use Modules\Support\Eloquent\Model;

class NullResponse extends GatewayResponse
{
    /**
     * Instance of model
     *
     * @var \Modules\Support\Eloquent\Model
     */
    private Model $entity;

    public function __construct(Model $entity)
    {
        $this->entity = $entity;
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
}
