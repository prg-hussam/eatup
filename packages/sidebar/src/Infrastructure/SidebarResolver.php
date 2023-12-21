<?php

namespace Prgayman\Sidebar\Infrastructure;

use Prgayman\Sidebar\Sidebar;

interface SidebarResolver
{
    /**
     * @param  string  $name
     * @return Sidebar
     */
    public function resolve($name);
}
