<?php

namespace Modules\Coupon\Entities;


use Modules\Support\Money;
use Illuminate\Support\Arr;
use Modules\Support\Eloquent\Model;
use Modules\Coupon\Meta\Limitations;
use Modules\Coupon\Meta\Restrictions;
use Modules\Support\Eloquent\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Coupon\Enums\DiscountTypeCases;

class Coupon extends Model
{
    use Translatable, SoftDeletes;


    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatable = ['name'];




    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'value',
        'discount_type',
        'used',
        'meta',
        'start_date',
        'end_date',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'meta' => "array",
        'start_date' => "date:Y-m-d",
        'end_date' => "date:Y-m-d",
    ];


    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addActiveGlobalScope();
    }

    /**
     * Get limitations
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function limitations(): Attribute
    {
        return Attribute::make(
            get: fn () => new Limitations(Arr::get($this->meta, 'limitations', []))
        );
    }

    /**
     * Get Restrictions
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function restrictions(): Attribute
    {
        return Attribute::make(
            get: fn () => new Restrictions(Arr::get($this->meta, 'restrictions', []))
        );
    }

    /**
     * Find by code
     *
     * @param string $code
     * @return \Modules\Coupon\Entities\Coupon|null
     */
    public static function findByCode(string $code): ?Coupon
    {
        return self::where(\DB::raw('BINARY `code`'), $code)->first();
    }

    /**
     * Determine if this coupon is valid
     *
     * @return bool
     */
    public function valid(): bool
    {
        if ($this->hasStartDate() && $this->hasEndDate()) {
            return $this->startDateIsValid() && $this->endDateIsValid();
        }

        if ($this->hasStartDate()) {
            return $this->startDateIsValid();
        }

        if ($this->hasEndDate()) {
            return $this->endDateIsValid();
        }

        return true;
    }

    /**
     * Determine if this coupon is invalid
     *
     * @return bool
     */
    public function invalid(): bool
    {
        return !$this->valid();
    }

    /**
     * Determine if has this coupon start date
     *
     * @return bool
     */
    private function hasStartDate(): bool
    {
        return !is_null($this->start_date);
    }

    /**
     * Determine if has this coupon end date
     *
     * @return bool
     */
    private function hasEndDate(): bool
    {
        return !is_null($this->end_date);
    }


    /**
     * Determine if has this coupon has end date is valid
     *
     * @return bool
     */
    private function startDateIsValid(): bool
    {
        return today() >= $this->start_date;
    }

    /**
     * Determine if has this coupon has end date is valid
     *
     * @return bool
     */
    private function endDateIsValid(): bool
    {
        return today() <= $this->end_date;
    }

    /**
     * Determine if usage limit reached
     *
     * @param string $customerEmail
     * @return bool
     */
    public function usageLimitReached(?string $customerEmail = null): bool
    {
        return $this->perCouponUsageLimitReached() || $this->perCustomerUsageLimitReached($customerEmail);
    }

    /**
     * Determine if per Coupon usage limit reached
     *
     * @return bool
     */
    public function perCouponUsageLimitReached(): bool
    {
        if (is_null($this->limitations->per_coupon)) {
            return false;
        }

        return $this->used >= $this->limitations->per_coupon;
    }

    /**
     * Determine if coupon has no usage limit for customers
     *
     * @return bool
     */
    private function couponHasNoUsageLimitForCustomers(): bool
    {
        return is_null($this->limitations->per_customer);
    }

    /**
     * Determine if per customer usage limit reached
     *
     * @param string $customerEmail
     * @return bool
     */
    public function perCustomerUsageLimitReached(?string $customerEmail = null): bool
    {
        if ($this->couponHasNoUsageLimitForCustomers()) {
            return false;
        }

        $customerId = !is_null($customerEmail) ? Customer::findByEmail($customerEmail) : auth("customer")->id();

        $used = 0;
        if ($this->isTargetShipment()) {
            $used = $this->shipments()
                ->whereHas(
                    'team',
                    fn ($query) => $query->where("customer_id", $customerId)
                )
                ->count();
        } elseif ($this->isTargetSubscription()) {
            $used = $this->subscriptions()
                ->where("customer_id", $customerId)
                ->count();
        }

        return $used >= $this->limitations->per_customer;
    }

    /**
     * Get value
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function value(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->isPercent() ? $value : Money::inDefaultCurrency($value)
        );
    }
    /**
     * Determine if percent
     *
     * @return bool
     */
    public function isPercent(): bool
    {
        return  $this->discount_type == DiscountTypeCases::Percent->value;
    }

    /**
     * Get minimum spend
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function minimumSpend(): Attribute
    {
        return Attribute::make(
            get: fn () => !is_null($this->restrictions->minimum_spend)
                ? Money::inDefaultCurrency($this->restrictions->minimum_spend)
                : null
        );
    }

    /**
     * Get maximum spend
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function maximumSpend(): Attribute
    {
        return Attribute::make(
            get: fn () => !is_null($this->restrictions->maximum_spend)
                ? Money::inDefaultCurrency($this->restrictions->maximum_spend)
                : null
        );
    }

    /**
     * Calculate discount
     *
     * @param \Modules\Support\Money $amount
     * @return \Modules\Support\Money
     */
    public function calculateDiscount(Money $amount): Money
    {
        $discount = $this->value;

        if ($this->isPercent()) {
            $discount = Money::inDefaultCurrency($amount->amount() * ($discount / 100));
        }

        return $discount;
    }

    /**
     * Update this coupon used one
     *
     * @return void
     */
    public function usedOnce(): void
    {
        $this->increment('used');
    }
}