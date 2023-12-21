<?php

namespace App;

class Platform
{
    /**
     * Check platform is installed
     *
     * @return bool
     */
    public static function installed(): bool
    {
        return (bool) config('app.installed');
    }

    /**
     * Get paginate per page
     *
     * @return int
     */
    public static function paginate(): int
    {
        return 10;
    }

    /**
     * Check user in admin panel
     *
     * @return bool
     */
    public static function inAdminPanel(): bool
    {
        try {
            return app('inAdminPanel');
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check system is enable use domain
     * @return bool
     */
    public static function routeEnableDomain(): bool
    {
        return  config('platform.modules.core.config.enable_domain', false);
    }

    /**
     * Determine if force https
     *
     * @return bool
     */
    public static function forceHttps(): bool
    {
        return (bool) config('app.force_https');
    }
}
