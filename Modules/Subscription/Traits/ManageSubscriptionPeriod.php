<?php

namespace Modules\Subscription\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Subscription\Enums\SubscriptionStatuses;
use Modules\Support\Money;

trait ManageSubscriptionPeriod
{
    /**
     * Check if subscription is active.
     *
     * @return bool
     */
    public function active(): bool
    {
        return ($this->started() &&  !$this->expired());
    }

    /**
     * Check if subscription is inactive.
     *
     * @return bool
     */
    public function inactive(): bool
    {
        return !$this->active();
    }


    /**
     * Check if subscription period has ended.
     *
     * @return bool
     */
    public function ended(): bool
    {
        return !is_null($this->ends_at) ? now()->gte($this->ends_at) : false;
    }

    /**
     * Check if subscription period has started.
     *
     * @return bool
     */
    public function started(): bool
    {
        return !is_null($this->starts_at) ? now()->gte($this->starts_at) : true;
    }

    /**
     * Check if subscription period has expired.
     *
     * @return bool
     */
    public function expired(): bool
    {
        return (!is_null($this->ends_at) && now()->gte($this->ends_at));
    }

    /**
     * Get the subscription end date
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function endDate(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!is_null($this->ends_at)) {
                    return $this->ends_at;
                }
                return null;
            }
        );
    }



    /**
     * Scope subscriptions with ending periods.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $dayRange
     * @return void
     */
    public function scopeFindEndingPeriod(Builder $query, int $dayRange = 3): void
    {
        $query->whereBetween('ends_at', [now(), now()->addDays($dayRange)]);
    }

    /**
     * Scope subscriptions with ended periods.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopeFindEndedPeriod(Builder $query): void
    {
        $query->where('ends_at', '<=', now());
    }

    /**
     * Scope subscriptions with ending periods.
     *
     * @param int $dayRange
     * @return bool
     */
    public function endingPeriod(int $dayRange = 3): bool
    {
        return is_null($this->end_date) ? false : $this->end_date->between(now(), now()->addDays($dayRange));
    }

    /**
     * Scope all active subscriptions for a user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeActive(Builder $query)
    {
        $query->status(SubscriptionStatuses::Active);
    }

    /**
     * Scope all expired subscriptions for a user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeExpired(Builder $query)
    {
        $query->status(SubscriptionStatuses::Expired);
    }



    /**
     * Scope all expired subscriptions for a user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeNotStarts(Builder $query)
    {
        $query->where("starts_at", "<", now());
    }

    /**
     * Scope all active subscriptions for a user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeStatus(Builder $query, SubscriptionStatuses $status): void
    {
        switch ($status) {
            case SubscriptionStatuses::Active:
                $query->where(
                    fn (Builder $query) => $query->whereNull("starts_at")
                        ->orWhere('starts_at', '<', now())
                )

                    ->where(
                        fn (Builder $query) =>
                        $query->where(
                            fn (Builder $query) => $query->whereNotNull("ends_at")
                                ->where('ends_at', '>=', now())
                        )
                    );
                break;
            case SubscriptionStatuses::Expired:
                $query
                    ->where(
                        fn (Builder $query) =>
                        $query->where(
                            fn (Builder $query) => $query->whereNotNull("trial_ends_at")
                                ->where('trial_ends_at', '<=', now())
                        )->orWhere(
                            fn (Builder $query) => $query->whereNotNull("ends_at")
                                ->where('ends_at', '<=', now())
                        )
                    );
                break;
        }
    }

    /**
     * Get remaining period price
     *
     * @param \Modules\Support\Money
     */
    public function getRemainingPeriodPrice(): Money
    {
        if (
            !is_null($this->end_date) &&
            !is_null($this->starts_at) &&
            !is_null($this->total) &&

            $this->active()
        ) {
            return Money::inDefaultCurrency(
                now()->diffInSeconds($this->end_date) * ($this->total->amount() / $this->starts_at->diffInSeconds($this->end_date))
            );
        }

        return Money::inDefaultCurrency(0);
    }
}