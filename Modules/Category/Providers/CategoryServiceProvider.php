<?php

namespace Modules\Category\Providers;

use App\Platform;
use Illuminate\Support\ServiceProvider;
use Modules\Category\Admin\CategoryTabs;
use Modules\Dashboard\Ui\Facades\TabManager;

class CategoryServiceProvider extends ServiceProvider
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
            TabManager::register('categories', CategoryTabs::class);
        }
    }
}