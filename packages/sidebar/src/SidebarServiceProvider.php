<?php

namespace Prgayman\Sidebar;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Prgayman\Sidebar\Infrastructure\SidebarFlusherFactory;
use Prgayman\Sidebar\Infrastructure\SidebarResolverFactory;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @var string
     */
    protected $shortName = 'sidebar';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register config
        $this->registerConfig();

        // Bind SidebarResolver
        $this->app->bind('Prgayman\Sidebar\Infrastructure\SidebarResolver', function (Application $app) {
            $resolver = SidebarResolverFactory::getClassName(
                $app['config']->get('sidebar.cache.method')
            );

            return $app->make($resolver);
        });

        // Bind SidebarFlusher
        $this->app->bind('Prgayman\Sidebar\Infrastructure\SidebarFlusher', function (Application $app) {
            $resolver = SidebarFlusherFactory::getClassName(
                $app['config']->get('sidebar.cache.method')
            );

            return $app->make($resolver);
        });

        // Bind manager
        $this->app->singleton('Prgayman\Sidebar\SidebarManager');

        // Bind Menu
        $this->app->bind(
            'Prgayman\Sidebar\Menu',
            'Prgayman\Sidebar\Domain\DefaultMenu'
        );

        // Bind Group
        $this->app->bind(
            'Prgayman\Sidebar\Group',
            'Prgayman\Sidebar\Domain\DefaultGroup'
        );

        // Bind Item
        $this->app->bind(
            'Prgayman\Sidebar\Item',
            'Prgayman\Sidebar\Domain\DefaultItem'
        );

        // Bind Badge
        $this->app->bind(
            'Prgayman\Sidebar\Badge',
            'Prgayman\Sidebar\Domain\DefaultBadge'
        );

        // Bind Renderer
        $this->app->bind(
            'Prgayman\Sidebar\Presentation\SidebarRenderer',
            'Prgayman\Sidebar\Presentation\Illuminate\IlluminateSidebarRenderer'
        );
    }

    /**
     * Register config
     *
     * @return void
     */
    protected function registerConfig()
    {
        $location = __DIR__.'/../config/'.$this->shortName.'.php';

        $this->mergeConfigFrom(
            $location,
            $this->shortName
        );

        $this->publishes([
            $location => config_path($this->shortName.'.php'),
        ], 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Prgayman\Sidebar\Menu',
            'Prgayman\Sidebar\Item',
            'Prgayman\Sidebar\Group',
            'Prgayman\Sidebar\Badge',
            'Prgayman\Sidebar\SidebarManager',
            'Prgayman\Sidebar\Presentation\SidebarRenderer',
            'Prgayman\Sidebar\Infrastructure\SidebarResolver',
        ];
    }
}
