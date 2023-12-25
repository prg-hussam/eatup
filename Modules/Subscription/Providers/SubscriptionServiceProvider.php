<?php

namespace Modules\Subscription\Providers;

use App\Platform;
use Illuminate\Support\ServiceProvider;
use Modules\Subscription\Admin\PlanTabs;
use Modules\Dashboard\Ui\Facades\TabManager;

class SubscriptionServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

        if (!Platform::installed()) {
            return;
        }

        if (Platform::inAdminPanel()) {
            TabManager::register('plans', PlanTabs::class);
        }
    }
}