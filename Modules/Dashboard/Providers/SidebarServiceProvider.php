<?php

namespace Modules\Dashboard\Providers;

use App\Platform;
use Illuminate\Support\ServiceProvider;
use Modules\Dashboard\Sidebar\AdminSidebar;
use Prgayman\Sidebar\SidebarManager;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(SidebarManager $manager)
    {
        if (!Platform::installed()) {
            return;
        }

        if ($this->app['inAdminPanel']) {
            $manager->register(AdminSidebar::class);
        }
    }
}
