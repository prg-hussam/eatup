<?php

namespace Modules\Coupon\Meta;

use Illuminate\Support\Arr;

/**
 * @attribute minimum_spend
 * @attribute maximum_spend
 * @attribute payment_method
 * @attribute shipping_companies
 * @attribute max_weight
 * @attribute min_weight
 * @attribute shipment_payment_method
 * @attribute subscription_period
 * @attribute plans
 */
class Restrictions
{
    /**
     *
     */

    /**
     * Create a new restrictions instance.
     *
     * @param array $restrictions
     * @return void
     */
    public function __construct(protected array $restrictions)
    {
    }

    /**
     * Get restrictions attributes
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return Arr::get($this->restrictions, $name);
    }
}
