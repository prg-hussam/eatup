<?php

namespace Modules\Dashboard\Ui\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void register(string $name, string $tabsClass)
 * @method static void extend(string $name, string $extenderClass)
 *
 * @see \Modules\Dashboard\Ui\Tabs\TabManager
 */
class TabManager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Modules\Dashboard\Ui\Tabs\TabManager::class;
    }
}
