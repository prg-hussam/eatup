<?php

namespace Modules\Core\Providers;

use App\Platform;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Repositories\SettingRepository;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Core module specific middleware.
     *
     * @var array
     */
    protected $middleware = [
        'lockScreen' => \Modules\User\Http\Middleware\LockScreenMiddleware::class,
    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (Platform::installed()) {
            $this->registerSetting();
            $this->activitylog();
            $this->setupAppCacheDriver();
            $this->setupAppDate();
            $this->setupAppTimezone();
            $this->setupAppName();
            $this->setupMailConfig();
            $this->registerMiddleware();
            $this->registerInAdminPanelState();
            $this->blacklistAdminRoutesOnFrontend();
        }
    }

    /**
     * Register setting binding.
     *
     * @return void
     */
    private function registerSetting()
    {
        $this->app->singleton('setting', function ($app, $params) {
            $group = $params['group'] ?? 'system';

            return new SettingRepository(Setting::allCached($group), $group);
        });
    }

    /**
     * Enabled activity log.
     *
     * @return void
     */
    private function activitylog()
    {
        $this->app['config']->set(
            'activitylog.enabled',
            setting(
                'activitylog.enabled',
                $this->app['config']->get('activitylog.enabled')
            )
        );

        $this->app['config']->set(
            'activitylog.delete_records_older_than_days',
            setting(
                'activitylog.delete_records_older_than_days',
                $this->app['config']->get('activitylog.delete_records_older_than_days')
            )
        );
    }

    /**
     * Setup application cache driver.
     *
     * @return void
     */
    private function setupAppCacheDriver()
    {
        $this->app['config']->set('cache.default', config('app.cache') ? config('cache.default') : 'array');
    }

    /**
     * Setup app date
     *
     * @return void
     */
    private function setupAppDate(): void
    {
        Date::macro('getDayIndex', function (string $day) {
            switch ($day) {
                case "sunday":
                    return Carbon::SUNDAY;
                case "monday":
                    return Carbon::MONDAY;
                case "tuesday":
                    return Carbon::TUESDAY;
                case "wednesday":
                    return Carbon::WEDNESDAY;
                case "thursday":
                    return Carbon::THURSDAY;
                case "friday":
                    return Carbon::FRIDAY;
                case "saturday":
                    return Carbon::SATURDAY;
            }
        });

        Date::setWeekStartsAt(Date::getDayIndex(setting('week_starts_at', 'sunday')));
        Date::setWeekEndsAt(Date::getDayIndex(setting('week_ends_at', 'saturday')));
    }

    /**
     * Setup application timezone.
     *
     * @return void
     */
    private function setupAppTimezone()
    {
        $timezone = setting('default_timezone') ?? config('app.timezone');

        date_default_timezone_set($timezone);

        $this->app['config']->set('app.timezone', $timezone);
    }

    /**
     * Setup application name.
     *
     * @return void
     */
    private function setupAppName()
    {
        $this->app['config']->set('app.name',  setting('app_name', config('app.name')));
    }

    /**
     * Setup application mail config.
     *
     * @return void
     */
    private function setupMailConfig()
    {
        $this->app['config']->set('mail.default', 'smtp');
        $this->app['config']->set('mail.from.address', setting('mail_from_address'));
        $this->app['config']->set('mail.from.name', setting('mail_from_name'));
        $this->app['config']->set('mail.mailers.smtp.host', setting('mail_host'));
        $this->app['config']->set('mail.mailers.smtp.port', setting('mail_port'));
        $this->app['config']->set('mail.mailers.smtp.username', setting('mail_username'));
        $this->app['config']->set('mail.mailers.smtp.password', setting('mail_password'));
        $this->app['config']->set('mail.mailers.smtp.encryption', setting('mail_encryption'));
    }

    /**
     * Register the filters.
     *
     * @return void
     */
    private function registerMiddleware()
    {
        foreach ($this->middleware as $name => $middleware) {
            $this->app['router']->aliasMiddleware($name, $middleware);
        }
    }

    /**
     * Register inAdminPanel state to the IoC container.
     *
     * @return void
     */
    private function registerInAdminPanelState()
    {
        $this->app['inAdminPanel'] = $this->app->runningInConsole()
            ? false
            : (Platform::routeEnableDomain()
                ?  request()->getHost() === config('platform.modules.core.config.routes.web.admin.domain')
                : $this->app['request']->segment(
                    in_array(
                        $this->app['request']->segment(1),
                        setting('supported_locales')
                    )
                        ? 2
                        : 1
                ) === config('platform.modules.core.config.routes.web.admin.prefix')
            );
    }

    /**
     * Blacklist admin routes on frontend for ziggy package.
     *
     * @return void
     */
    private function blacklistAdminRoutesOnFrontend()
    {
        if (!$this->app['inAdminPanel']) {
            $this->app['config']->set('ziggy.blacklist', ['admin.*']);
        }
    }
}
