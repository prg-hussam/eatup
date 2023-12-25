<?php

namespace Modules\Coupon\Admin;

use Modules\Coupon\Enums\DiscountTypeCases;
use Modules\Dashboard\Ui\Tabs\Tab;
use Modules\Dashboard\Ui\Tabs\Tabs;

class CouponTabs extends Tabs
{
    public function make()
    {
        $this->add($this->general())
            ->add($this->usageLimits());
    }

    public function general()
    {
        return tap(new Tab('general', 'General', __('admin.coupons.tabs.general')), function (Tab $tab) {
            $tab->active()
                ->translationFields('name')
                ->data([
                    "discountTypes" => DiscountTypeCases::toArrayWithTranslations(),
                ])
                ->fields([
                    'name',
                    'code',
                    'is_percent',
                    'value',
                    'start_date',
                    'end_date',
                    'is_active',
                ]);
        });
    }

    private function usageLimits()
    {
        return tap(new Tab('usage_limits', 'UsageLimits', __('admin.coupons.tabs.usage_limits')), function (Tab $tab) {
            $tab
                ->fields([
                    "meta.limitations.per_coupon",
                    "meta.limitations.per_customer"
                ]);
        });
    }
}