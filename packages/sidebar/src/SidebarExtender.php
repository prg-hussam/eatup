<?php

namespace Prgayman\Sidebar;

interface SidebarExtender
{
    /**
     * @param  Menu  $menu
     * @return Menu
     */
    public function extendWith(Menu $menu);
}
