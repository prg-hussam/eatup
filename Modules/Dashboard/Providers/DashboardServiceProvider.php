<?php

namespace Modules\Dashboard\Providers;

use App\Platform;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Modules\Dashboard\Http\ViewComposers\LayoutComposer;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (! Platform::installed()) {
            return;
        }

        View::composer('app', LayoutComposer::class);
    }
}
