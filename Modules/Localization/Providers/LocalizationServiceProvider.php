<?php

namespace Modules\Localization\Providers;

use App\Platform;
use Illuminate\Support\ServiceProvider;
use Modules\Localization\Admin\CityTabs;
use Modules\Localization\Admin\ProvinceTabs;
use Modules\Dashboard\Ui\Facades\TabManager;

class LocalizationServiceProvider extends ServiceProvider
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
            TabManager::register('provinces', ProvinceTabs::class);
            TabManager::register('cities', CityTabs::class);
        }
    }
}