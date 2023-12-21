<?php

namespace Modules\Dashboard\Sidebar;

use Modules\Dashboard\Ui\Sidebar\BaseSidebarExtender;
use Prgayman\Sidebar\Group;
use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Menu;

class AdminSidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group('admin.sidebar.menu', function (Group $group) {
            $group->item('admin.sidebar.dashboard', function (Item $item) {
                $item->icon('mdi mdi-speedometer');
                $item->route('admin.dashboard.index');
                $item->isActiveWhen(route('admin.dashboard.index', null, false));
            });
        });

        $menu->group('admin.sidebar.system', function (Group $group) {
            $group->hideHeading(
                !$this->auth->canAny([
                    'admin.settings.index',
                    'admin.translations.index',
                    'admin.users.index',
                    'admin.roles.index',
                ])
            );
            $group->weight(10);
        });
    }
}
