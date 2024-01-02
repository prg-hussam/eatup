<?php

namespace Modules\Payment;

use Modules\Payment\Contracts\GatewayInterface;
use Modules\Support\Money;

abstract class Gateway implements GatewayInterface
{
    /**
     * Gateway label
     *
     * @var string
     */
    public string $label;

    /**
     * Gateway description
     *
     * @var string
     */
    public string $description;

    /**
     * Gateway logo
     *
     * @var string
     */
    public ?string $logo = null;

    /**
     * Gateway balance
     *
     * @var \Modules\Support\Money
     */
    public ?Money $balance = null;

    /**
     * Gateway determine if gateway is wallet
     *
     * @var boolean
     */
    public bool $isWallet = false;

    /**
     * Determine if Gateway available or not
     *
     * @return bool
     */
    public function available(): bool
    {
        return true;
    }

    /**
     * Execute handle payment gateway
     *
     * @return void
     */
    public function handle(): void
    {
    }
}
