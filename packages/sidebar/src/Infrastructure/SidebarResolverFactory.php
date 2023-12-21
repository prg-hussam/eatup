<?php

namespace Prgayman\Sidebar\Infrastructure;

use Illuminate\Support\Str;
use Prgayman\Sidebar\Exceptions\SidebarResolverNotSupported;

class SidebarResolverFactory
{
    /**
     * @param $name
     * @return string
     *
     * @throws SidebarResolverNotSupported
     */
    public static function getClassName($name)
    {
        if ($name) {
            $class = __NAMESPACE__.'\\'.Str::studly($name).'CacheResolver';

            if (class_exists($class)) {
                return $class;
            }

            throw new SidebarResolverNotSupported('Chosen caching type is not supported. Supported: [static, user-based]');
        }

        return __NAMESPACE__.'\\ContainerResolver';
    }
}
