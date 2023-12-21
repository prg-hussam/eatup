<?php

namespace App\Providers;

use App\Platform;
use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FortifyConfigServiceProvider extends ServiceProvider
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

        $adminConfig = config('platform.modules.core.config.routes.web.admin');

        if (Platform::routeEnableDomain()) {
            $this->app['config']->set('fortify.prefix', LaravelLocalization::setLocale());
            $this->app['config']->set('fortify.domain', $adminConfig['domain']);
        } else {
            $this->app['config']->set('fortify.prefix', LaravelLocalization::setLocale() . "/{$adminConfig['prefix']}");
            $this->app['config']->set('fortify.redirects.logout', LaravelLocalization::setLocale() . "/{$adminConfig['prefix']}/login");
            $this->app['config']->set('fortify.redirects.login', LaravelLocalization::setLocale() . "/{$adminConfig['prefix']}");
        }
    }
}
