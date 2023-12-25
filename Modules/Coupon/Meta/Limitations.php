<?php

namespace Modules\Coupon\Meta;

use Illuminate\Support\Arr;

/**
 * @attribute per_coupon
 * @attribute per_customer
 */
class Limitations
{
    /**
     * Create a new limitations instance.
     *
     * @param array $limitations
     * @return void
     */
    public function __construct(protected array $limitations)
    {
    }

    /**
     * Get limitations attributes
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return Arr::get($this->limitations, $name);
    }
}
