<?php

namespace Modules\Subscription\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Core\Enums\PaymentStatus;
use Modules\Coupon\ApplyCoupon;
use Modules\Coupon\Entities\Coupon;
use Modules\Subscription\Entities\Plan;
use Modules\Subscription\Entities\Subscription;
use Modules\Subscription\Enums\SubscriptionPeriods;
use Modules\Support\Money;
use Modules\User\Entities\Customer;

class SubscriptionService
{
    /**
     * Create Subscription
     *
     * @param \Illuminate\Http\Request $request
     * @return \Modules\Subscription\Entities\Subscription
     */
    public function create(Request $request, Plan $plan): Subscription
    {
        $coupon = !is_null($request->coupon) ? $this->applyCoupon($request, $plan) : null;

        return tap($this->store($request, $plan, $coupon), function ($subscription) use ($coupon) {
            if (!is_null($coupon)) {
                $this->incrementCouponUsage($coupon);
            }
        });
    }

    /**
     * Apply Coupon
     *
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Subscription\Entities\Plan $plan
     * @return \Modules\Coupon\Entities\Coupon
     */
    public function applyCoupon(Request $request, Plan $plan)
    {
    }

    /**
     * Store Subscription
     *
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Subscription\Entities\Plan $plan
     * @param \Modules\Coupon\Entities\Coupon|null $coupon
     * @return \Modules\Subscription\Entities\Subscription
     */
    public function store(Request $request, Plan $plan, ?Coupon $coupon = null): Subscription
    {

        $customer = $request->user("customer");
        $paymentValues = $this->paymentValues($request, $plan, $coupon);

        $startsAt = now();

        $endDate = (clone $startsAt)->addDays($plan->duration);

        return Subscription::create([
            'customer_id' => $customer->id,
            'plan_id' => $plan->id,
            'ends_at' => $endDate,
            "starts_at" => $startsAt,
            'total' => $paymentValues["total"]->amount(),
            'sub_total' => $paymentValues["subTotal"]->amount(),
            'tax' => $paymentValues["tax"]->amount(),
            "payment_method" => 'Mada',
            "payment_status" => PaymentStatus::Unpaid->value,
            'currency' => setting('default_currency'),
            'locale' => locale(),
            "coupon_id" => $coupon?->id,
            "discount" => !is_null($coupon) ? $paymentValues["coupon"]["discount"]->amount() : 0
        ]);
    }

    /**
     * Get subscription expiration
     *
     * @param \Modules\User\Entities\Customer $user
     * @param string $period
     * @param \Carbon\Carbon $startsAt
     * @param \Modules\Support\Money $total
     * @return \Carbon\Carbon
     */
    private function getEndDate(Customer $user, Plan $plan, string $period, Carbon $startDate, Money $total): Carbon
    {
        $endDate = (clone $startDate)->{$period === SubscriptionPeriods::Annually->value ? "addYear" : "addMonth"}();

        if (!$user->subscription->ended() && $user->isSubscriptionUpgrade($plan)) {
            $this->addExtraTime($user, $endDate, $startDate, $total);
        }

        return $endDate;
    }

    /**
     * Add extra time
     *
     * @param \Modules\User\Entities\Customer $user
     * @param \Carbon\Carbon $endDate
     * @param \Carbon\Carbon $startsAt
     * @param \Modules\Support\Money $total
     * @return void
     */
    private function addExtraTime(Customer $user, Carbon $endDate, Carbon $startDate, Money $total): void
    {
        $endDate->addSeconds(
            intval(
                ceil(
                    $user->subscription->getRemainingPeriodPrice()->amount() / ($total->amount() / $startDate->diffInSeconds($endDate))
                )
            )
        );
    }

    /**
     * Get payment values
     *
     * @return array
     */
    public function paymentValues(Request $request, Plan $plan, ?Coupon $coupon = null): array
    {

        $selectedDiningPeriodIds = collect($request->periods)->pluck('id')->toArray();

        $subTotal = $plan->diningPeriods->whereIn('id', $selectedDiningPeriodIds)->sum('pivot.price');
        $subTotal = Money::inDefaultCurrency($subTotal);

        if (!is_null($coupon)) {
            $discount = $coupon->calculateDiscount($subTotal);
        } else {
            $discount = Money::inDefaultCurrency(0);
        }

        $tax = Money::inDefaultCurrency(($subTotal->amount() - $discount->amount()) * (setting('vat', 15) / 100));

        return [
            "subTotal" => $subTotal,
            "tax" =>  $tax,
            "total" => $subTotal->subtract($discount)->add($tax),
            "coupon" => !is_null($coupon) ? [
                "code" => $coupon->code,
                "discount" => $discount
            ] : null
        ];
    }

    /**
     * Delete a subscription
     *
     * @param \Modules\Subscription\Entities\Subscription $subscription
     * @return void
     */
    public function delete(Subscription $subscription): void
    {
        $subscription->forceDelete();
    }

    /**
     * Increment coupon usage once
     *
     * @param \Modules\Coupon\Entities\Coupon $coupon
     * @return void
     */
    private function incrementCouponUsage(Coupon $coupon): void
    {
        $coupon->usedOnce();
    }
}