<?php

namespace Modules\Payment;

use Illuminate\Support\Collection;
use Modules\Support\Manager;

class GatewayManager extends Manager
{
    /**
     * Get all Gateway instanceof interface
     *
     * @return \Illuminate\Support\Collection
     */
    public function instanceof(mixed $interface): Collection
    {
        return $this->all()->filter(function ($gateway) use ($interface) {
            if ($gateway instanceof $interface && $gateway->available()) {
                if (method_exists($gateway, "handle")) {
                    $gateway->handle();
                }
                return true;
            }
            return false;
        });
    }
}