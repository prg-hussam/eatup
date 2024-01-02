<?php

namespace Modules\Payment\Traits;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Enums\PaymentStatus;

trait HasPayment
{
    /**
     * Get payment id
     *
     * @return string
     */
    public function getPaymentId(): string
    {
        return $this->reference_no;
    }

    /**
     * Get payment description
     *
     * @return string
     */
    abstract public function getPaymentDescription(): string;

    /**
     * Get payment return url
     *
     * @return string
     */
    abstract public function getPaymenReturnUrl(): string;

    /**
     * Scope with paid.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function scopePaid(Builder $builder)
    {
        $builder->where('payment_status', PaymentStatus::Paid->value);
    }

    /**
     * Scope with unPaid.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function scopeUnPaid(Builder $builder)
    {
        $builder->where('payment_status', PaymentStatus::Unpaid->value);
    }
}
