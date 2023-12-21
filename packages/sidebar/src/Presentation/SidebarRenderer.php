<?php

namespace Prgayman\Sidebar\Presentation;

use Prgayman\Sidebar\Sidebar;

interface SidebarRenderer
{
    /**
     * @param  Sidebar  $sidebar
     * @return array
     */
    public function render(Sidebar $sidebar);
}
