<?php

namespace Modules\Subscription\Entities;


use Carbon\Carbon;
use Modules\Support\Money;
use Modules\Support\Eloquent\Model;
use Modules\User\Entities\Customer;
use Modules\Core\Enums\PaymentStatus;
use Modules\Coupon\Eloquent\HasCoupon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Subscription\Enums\SubscriptionStatuses;
use Modules\Subscription\Traits\ManageSubscriptionPeriod;

class Subscription extends Model
{
    use SoftDeletes, HasCoupon, ManageSubscriptionPeriod;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ends_at' => 'datetime',
        'starts_at' => 'datetime',

    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ["tax_percentage", "payment_method_name"];


    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($subscription) {
            $subscription->reference_no = generateUniqueId("SU");
        });
    }

    /**
     * Get customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class)
            ->withTrashed()
            ->withoutGlobalScope('active');
    }

    /**
     * Get plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class)
            ->withTrashed()
            ->withoutGlobalScope('active');
    }

    /**
     * Get the Starts At
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function startsAt(): Attribute
    {
        return Attribute::make(
            get: fn ($startsAt) => is_null($startsAt) ? $this->created_at : Carbon::parse($startsAt, config('app.timezone'))
        );
    }

    /**
     * Get the subTotal
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function subTotal(): Attribute
    {
        return Attribute::make(
            get: fn ($subTotal) => !is_null($subTotal) ? Money::inDefaultCurrency($subTotal) : null
        );
    }

    /**
     * Get the tax
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function tax(): Attribute
    {
        return Attribute::make(
            get: fn ($tax) => !is_null($tax) ?  Money::inDefaultCurrency($tax) : null
        );
    }

    /**
     * Get the plan's monthly subscription
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function total(): Attribute
    {
        return Attribute::make(
            get: fn ($total) => !is_null($total) ?  Money::inDefaultCurrency($total) : null
        );
    }

    /**
     * Get tax percentage
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function taxPercentage(): Attribute
    {
        return Attribute::make(
            get: fn () => !is_null($this->tax) ? round((($this->tax->amount() / ($this->sub_total->amount() - $this->discount->amount())) * 100), 0) : null
        );
    }

    /**
     * Get the status
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->active()) {
                    return SubscriptionStatuses::Active->value;
                } elseif ($this->ended()) {
                    return SubscriptionStatuses::Expired->value;
                } else {
                    return "Unknown";
                }
            }
        );
    }
}