<?php

namespace Modules\Payment\Responses;

use Modules\Payment\Contracts\HasTransactionReference;
use Modules\Payment\GatewayResponse;
use Modules\Support\Eloquent\Model;
use Modules\Wallet\Entities\WalletTransaction;
use Modules\Wallet\Entities\WalletTransfer;

class WalletResponse extends GatewayResponse implements HasTransactionReference
{
    /**
     * Instance of model
     *
     * @var \Modules\Support\Eloquent\Model
     */
    private Model $entity;

    /**
     * Instance of wallet transaction
     *
     * @var \Modules\Wallet\Entities\WalletTransfer
     */
    private ?WalletTransfer $transfer = null;

    public function __construct(Model $entity, ?WalletTransfer $transfer = null)
    {
        $this->entity = $entity;
        $this->transfer = $transfer;
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
        return (string) $this->transfer->withdraw->id;
    }

    /** @inheritDoc */
    public function getMeta(): array
    {
        return [];
    }
}
