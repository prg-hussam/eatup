<?php

namespace Modules\Core\Providers;

use App\Platform;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const ADMIN_DASHBOARD = 'admin';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        if (!Platform::installed()) {
            return;
        }

        $this->configureRateLimiting();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        if (Platform::installed()) {
            $this->mapModuleRoutes();
        }
    }

    /**
     * Map routes from all enabled modules.
     *
     * @return void
     */
    private function mapModuleRoutes()
    {
        foreach ($this->app['modules']->allEnabled() as $module) {
            $this->groupRoutes("Modules\\{$module->getName()}\\Http\\Controllers", function () use ($module) {
                foreach (config('platform.modules.core.config.routes.web') as $config) {
                    $this->mapRoutes("{$module->getPath()}/Routes/{$config['file']}", $config);
                }
            });

            foreach (config('platform.modules.core.config.routes.api') as $config) {
                $this->mapApiRoutes(
                    "{$module->getPath()}/Routes/{$config['file']}",
                    "Modules\\{$module->getName()}\\Http\\Controllers\\{$config['namespace']}",
                    $config
                );
            }
        }
    }

    /**
     * Map api routes.
     *
     * @return void
     */
    private function mapApiRoutes($path, $namespace, $config)
    {
        if (!file_exists($path)) {
            return;
        }

        $route = Route::namespace($namespace)
            ->middleware($config['middleware']);

        if (Platform::routeEnableDomain()) {
            $route->domain($config['domain'])
                ->prefix($config['sub_prefix'])
                ->group(fn () => require_once $path);
        } else {
            $route->prefix("{$config['prefix']}/{$config['sub_prefix']}")
                ->group(fn () => require_once $path);
        }
    }

    /**
     * Group routes to common prefix and middleware.
     *
     * @param  string  $namespace
     * @param  \Closure  $callback
     * @return void
     */
    private function groupRoutes($namespace, $callback)
    {
        Route::group([
            'namespace' => $namespace,
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => ['web'],
        ], fn () => $callback());
    }

    /**
     * Map routes.
     *
     * @return void
     */
    private function mapRoutes($path, $config)
    {
        if (!file_exists($path)) {
            return;
        }

        $route = Route::middleware($config['middleware']);

        if (isset($config['namespace'])) {
            $route->namespace($config['namespace']);
        }

        if (isset($config['name'])) {
            $route->name($config['name']);
        }

        if (Platform::routeEnableDomain()) {
            $route->domain($config['domain'])
                ->group(fn () => require_once $path);
        } else {

            if (isset($config['prefix'])) {
                $route->prefix($config['prefix'])
                    ->group(fn () => require_once $path);
            } else {
                require_once $path;
            }
        }
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . $request->ip())
                ->response(function ($request, $headers) {
                    throw ValidationException::withMessages([
                        'username' => __('auth.throttle', ['seconds' => $headers['Retry-After']]),
                    ]);
                });
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}