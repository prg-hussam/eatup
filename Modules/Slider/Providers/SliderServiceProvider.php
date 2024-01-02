<?php

namespace Modules\Slider\Providers;

use App\Platform;
use Illuminate\Support\ServiceProvider;
use Modules\Dashboard\Ui\Facades\TabManager;
use Modules\Slider\Admin\SliderTabs;

class SliderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!Platform::installed()) {
            return;
        }

        if (Platform::inAdminPanel()) {
            TabManager::register('sliders', SliderTabs::class);
        }
    }
}