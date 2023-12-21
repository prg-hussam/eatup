<?php

namespace Modules\User\Providers;

use App\Platform;
use Illuminate\Support\ServiceProvider;
use Modules\Dashboard\Ui\Facades\TabManager;
use Modules\User\Admin\RoleTabs;
use Modules\User\Admin\UserTabs;

class UserServiceProvider extends ServiceProvider
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

        TabManager::register('roles', RoleTabs::class);
        TabManager::register('users', UserTabs::class);
    }
}
