<?php

namespace Modules\Payment\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array checkouts(string $merchantTransactionId,string $paymentMethod,\Modules\Support\Money $total,string $customerEmail,string $customerGivenName,string $customerSurname)
 * @method static array resourcePath(string $paymentMethod,string $resourcePath)
 *
 * @see \Modules\Payment\Services\HyperPay
 */
class HyperPay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Modules\Payment\Services\HyperPay::class;
    }
}
