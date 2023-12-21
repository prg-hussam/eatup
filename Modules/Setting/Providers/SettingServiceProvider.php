<?php

namespace Modules\Setting\Providers;

use App\Platform;
use Illuminate\Support\ServiceProvider;
use Modules\Dashboard\Ui\Facades\BoxManager;
use Modules\Setting\Admin\SettingBoxes;

class SettingServiceProvider extends ServiceProvider
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

        BoxManager::register('settings', SettingBoxes::class);
    }
}
