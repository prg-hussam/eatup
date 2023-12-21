<?php

namespace Prgayman\Sidebar\Presentation\Illuminate;

use Prgayman\Sidebar\Presentation\SidebarRenderer;
use Prgayman\Sidebar\Sidebar;

class IlluminateSidebarRenderer implements SidebarRenderer
{
    /**
     * @param  Sidebar  $sidebar
     * @return array|null
     */
    public function render(Sidebar $sidebar)
    {
        $menu = $sidebar->getMenu();

        if ($menu->isAuthorized()) {
            $groups = [];
            foreach ($menu->getGroups() as $group) {
                $groups[] = (new IlluminateGroupRenderer)->render($group);
            }

            return  $groups;
        }
    }
}
