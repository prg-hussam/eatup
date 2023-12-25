<?php

namespace Modules\Subscription\Sidebar;

use Prgayman\Sidebar\Group;
use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Menu;
use Modules\Dashboard\Ui\Sidebar\BaseSidebarExtender;

class AdminSidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group('admin.sidebar.menu', function (Group $group) {
            $group->item('admin.sidebar.plans', function (Item $item) {
                $item->icon('bx bxs-star');
                $item->weight(20);
                $item->route('admin.plans.index');
                $item->authorize(
                    $this->auth->can('admin.plans.index')
                );
            });
        });
    }
}