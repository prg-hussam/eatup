<?php

namespace Prgayman\Sidebar\Infrastructure;

use Illuminate\Support\Str;
use Prgayman\Sidebar\Exceptions\SidebarFlusherNotSupported;

class SidebarFlusherFactory
{
    /**
     * @param $name
     * @return string
     *
     * @throws SidebarFlusherNotSupported
     */
    public static function getClassName($name)
    {
        if ($name) {
            $class = __NAMESPACE__.'\\'.Str::studly($name).'SidebarFlusher';

            if (class_exists($class)) {
                return $class;
            }

            throw new SidebarFlusherNotSupported('Chosen caching type is not supported. Supported: [static, user-based]');
        }

        return __NAMESPACE__.'\\NullSidebarFlusher';
    }
}
