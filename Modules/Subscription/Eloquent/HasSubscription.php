<?php

namespace Modules\Subscription\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Core\Enums\AmountTypes;
use Modules\Core\Enums\PaymentStatus;
use Modules\Subscription\Entities\Plan;
use Modules\Subscription\Entities\Subscription;
use Modules\Subscription\Enums\NewSubscribeCases;
use Modules\Subscription\Enums\SubscriptionStatuses;
use Modules\Support\Enums\DateTimeFormatCases;
use Modules\Support\Money;

trait HasSubscription
{


    /**
     * Create a new instance of Subscription
     *
     * @var \Modules\Subscription\Entities\Subscription
     */
    protected ?Subscription $waitingStartSubscription;

    /**
     * Get subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
            ->with(['plan'])
            ->active()
            ->withDefault(function () {
                $subscription = $this->subscriptions()
                    ->notStarts()
                    ->latest()
                    ->first();
                return !is_null($subscription) &&
                    $subscription->expired()
                    ? $subscription
                    : null;
            });
    }

    /**
     * Get subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get plan
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function plan(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->subscription?->plan
        );
    }



    /**
     * Create a new subscription
     *
     * @param \Modules\Plan\Entities\Plan $plan
     * @param \Carbon\Carbon $starts
     * @param \Carbon\Carbon|null $endsAt
     * @param \Carbon\Carbon|null $trialEndsAt
     * @param \Modules\Subscription\Enums\SubscriptionPeriods|null $period
     * @param string|null $locale
     * @param string|null $paymentMethod
     * @param \Modules\Core\Enums\PaymentStatus $paymentStatus
     * @param \Modules\Support\Money|null $total
     * @param \Modules\Support\Money|null $subtotal
     * @param \Modules\Support\Money|null $tax
     * @param string|null $currency
     * @param float $currencyRate
     * @return \Modules\Subscription\Entities\Subscription
     */
    public function createNewSubscribe(
        Plan $plan,
        Carbon $starts,
        ?Carbon $endsAt = null,
        ?Carbon $trialEndsAt = null,
        ?string $locale = null,
        ?string $paymentMethod = null,
        ?PaymentStatus $paymentStatus = null,
        ?Money $total = null,
        ?Money $subtotal = null,
        ?Money $tax = null,
        ?string $currency = null,
        float $currencyRate = 1.0,
    ): Subscription {
        $subscription = $this->subscriptions()->create([
            "plan_id" => $plan->id,
            "starts_at" => $starts,
            "ends_at" => $endsAt,
            "trial_ends_at" => $trialEndsAt,
            "locale" => $locale ?: locale(),
            "payment_method" => $paymentMethod,
            "payment_status" => $paymentStatus?->value,
            "total" => $total?->amount(),
            "sub_total" => $subtotal?->amount(),
            "tax" => $tax?->amount(),
            "currency" => $currency ?: setting('default_currency'),
            "currency_rate" => $currencyRate,
        ]);

        return $subscription;
    }

    /**
     * Get customer subscription resource
     *
     * @return array
     */
    public function subscriptionResource(): array
    {
        $waitingStartSubscription = $this->waitingStartSubscription();

        return [
            "id" => $this->subscription->reference_no,
            "active" => $this->subscription->active(),
            "on_trial" => $this->subscription->onTrial(),
            "is_trial" => $this->subscription->isTrial(),
            "end_date" => dateTimeFormat($this->subscription->end_date, DateTimeFormatCases::DateTime),
            "ending_period" => $this->subscription->endingPeriod(),
            "canceled_at" => dateTimeFormat($this->subscription->canceled_at, DateTimeFormatCases::DateTime),
            "on_the_cancellation_schedule" => $this->subscription->active()
                ? $this->onTheSubscriptionCancellationSchedule()
                : false,
            "plan" => [
                "id" => $this->subscription->plan->id,
                "name" => $this->subscription->plan->name,

            ],
        ];
    }

    /**
     * Get the new Subscribe case
     *
     * @return \Modules\Subscription\Enums\NewSubscribeCases
     */
    public function getNewSubscribeCase(Plan $plan, ?array $currentSubscription = null): NewSubscribeCases
    {
        $currentSubscription = $currentSubscription ?: $this->subscriptionResource();

        if (
            $currentSubscription['on_the_cancellation_schedule'] &&
            $currentSubscription['plan']['id'] == $plan->id &&
            $currentSubscription['plan']['is_free'] == false
        ) {
            return NewSubscribeCases::RemoveCancellation;
        } else if (
            ($currentSubscription['wating_start_subscription'] &&
                $currentSubscription['wating_start_subscription']['plan']['id'] == $plan->id) ||
            $plan->is_free && $currentSubscription['on_the_cancellation_schedule']
        ) {
            return NewSubscribeCases::WaitingStartSubscription;
        } else if ($currentSubscription['plan']['level'] > $plan->level) {
            return NewSubscribeCases::Downgrade;
        } else if ($currentSubscription['plan']['level'] < $plan->level) {
            return NewSubscribeCases::Upgrade;
        } else if (
            $currentSubscription['plan']['id'] == $plan->id &&
            $currentSubscription['ending_period'] || !$currentSubscription['active']
        ) {
            return NewSubscribeCases::Renewal;
        } else if ($currentSubscription['plan']['id'] == $plan->id) {
            return NewSubscribeCases::CurrentPlan;
        }
    }

    /**
     * Determine if not allow customer new subscribe
     *
     * @return bool
     */
    public function notAllowNewSubscribe(Plan $plan): bool
    {
        if (
            $plan->is_free ||
            $this->hasWaitingStartSubscription() ||
            $this->onTheSubscriptionCancellationSchedule() ||
            ($this->subscription->plan->id == $plan->id &&
                !$this->subscription->endingPeriod() && !$this->subscription->ended())
        ) {
            return true;
        }
        return false;
    }

    /**
     * Determine if the plan is upgrade
     *
     * @param \Modules\Subscription\Entities\Plan $plan
     * @return bool
     */
    public function isSubscriptionUpgrade(Plan $plan): bool
    {
        return $this->subscription->plan->level < $plan->level;
    }

    /**
     * Determine if the plan is downgrade
     *
     * @param \Modules\Subscription\Entities\Plan $plan
     * @return bool
     */
    public function isSubscriptionDowngrade(Plan $plan): bool
    {
        return $this->subscription->plan->level > $plan->level;
    }

    /**
     * Determine if the plan is renewal
     *
     * @param \Modules\Subscription\Entities\Plan $plan
     * @return bool
     */
    public function isSubscriptionRenewal(Plan $plan): bool
    {
        return $this->subscription->plan->id == $plan->id;
    }

    /**
     * Get customer waiting start subscription
     *
     * @return \Modules\Subscription\Entities\Subscription
     */
    public function waitingStartSubscription(): ?Subscription
    {
        return $this->waitingStartSubscription ?? $this->waitingStartSubscription =  $this->subscriptions()->with("plan")
            ->status(SubscriptionStatuses::WaitingStart)
            ->first();
    }

    /**
     * Determine if a customer has waiting start subscription
     *
     * @return bool
     */
    public function hasWaitingStartSubscription(): bool
    {
        return !is_null($this->waitingStartSubscription());
    }

    /**
     * Check if the subscription allow cancellation
     *
     * @return bool
     */
    public function allowCurrentSubscriptionCancel(): bool
    {
        return  is_null($this->subscription->canceled_at) &&
            !is_null($this->subscription->end_date) &&
            $this->subscription->plan->is_free == false &&
            !$this->hasWaitingStartSubscription();
    }

    /**
     * Check if the subscription on the cancellation schedule
     *
     * @return bool
     */
    public function onTheSubscriptionCancellationSchedule(): bool
    {
        return !is_null($this->subscription->canceled_at) &&
            $this->subscription->active() &&
            !$this->subscription->canceled() &&
            !$this->subscription->plan->is_free;
    }

    /**
     * Get commission
     *
     * @param string $alias
     * @param string $type
     * @return array
     */
    public function getCommission(string $alias, string $type): array
    {
        if (!is_null($this->shipping_company_pricing_id) && !is_null($this->shippingCompanyPricing)) {
            $commission = $this->shippingCompanyPricing->pricings["commission"] ?? [];
        } else {
            $commission = $this->subscription->plan->shippingCompanyPricing->pricings["commission"] ?? [];
        }

        return $commission[$alias][$type] ?? [
            "benefit_type" => AmountTypes::Fixed->value,
            "benefit_maximum_weight" => 0,
            "benefit_weight_gain_cost" => 0
        ];
    }
}