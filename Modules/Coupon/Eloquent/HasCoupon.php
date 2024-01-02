<?php

namespace Modules\Coupon\Eloquent;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Coupon\Entities\Coupon;
use Modules\Support\Money;

trait HasCoupon
{
    /**
     * Get coupon information
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class)->withTrashed();
    }

    /**
     * Determine if this entity has coupon
     *
     * @return bool
     */
    public function hasCoupon(): bool
    {
        return !is_null($this->coupon);
    }

    /**
     * Get discount
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function discount(): Attribute
    {
        return Attribute::make(
            get: fn ($discount) => Money::inDefaultCurrency($discount)
        );
    }
}