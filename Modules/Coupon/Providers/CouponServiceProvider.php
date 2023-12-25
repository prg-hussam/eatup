<?php

namespace Modules\Coupon\Providers;

use App\Platform;
use Illuminate\Support\ServiceProvider;
use Modules\Coupon\Admin\CouponTabs;
use Modules\Dashboard\Ui\Facades\TabManager;

class CouponServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!Platform::installed()) {
            return;
        }

        if (Platform::inAdminPanel()) {
            TabManager::register('coupons', CouponTabs::class);
        }
    }
}