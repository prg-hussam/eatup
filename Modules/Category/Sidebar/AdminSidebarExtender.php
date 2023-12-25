<?php

namespace Modules\Category\Sidebar;

use Prgayman\Sidebar\Group;
use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Menu;
use Modules\Dashboard\Ui\Sidebar\BaseSidebarExtender;

class AdminSidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group('admin.sidebar.menu', function (Group $group) {
            $group->item('admin.sidebar.meals', function (Item $item) {
                $item->item('admin.sidebar.categories', function (Item $item) {
                    $item->weight(1);
                    $item->route('admin.categories.index');
                    $item->authorize(
                        $this->auth->can('admin.categories.index')
                    );
                });
            });
        });
    }
}