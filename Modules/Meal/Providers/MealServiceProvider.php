<?php

namespace Modules\Meal\Providers;

use App\Platform;
use Illuminate\Support\ServiceProvider;
use Modules\Meal\Admin\DiningPeriodTabs;
use Modules\Dashboard\Ui\Facades\TabManager;
use Modules\Meal\Admin\DiningPeriodTimeTabs;
use Modules\Meal\Admin\IngredientTabs;
use Modules\Meal\Admin\MealTabs;
use Modules\Meal\Admin\MenuTabs;

class MealServiceProvider extends ServiceProvider
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
            TabManager::register('dining_periods', DiningPeriodTabs::class);
            TabManager::register('dining_period_times', DiningPeriodTimeTabs::class);
            TabManager::register('ingredients', IngredientTabs::class);
            TabManager::register('meals', MealTabs::class);
            TabManager::register('menus', MenuTabs::class);
        }
    }
}
