<?php

namespace Modules\Coupon\Sidebar;

use Prgayman\Sidebar\Group;
use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Menu;
use Modules\Dashboard\Ui\Sidebar\BaseSidebarExtender;

class AdminSidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group('admin.sidebar.menu', function (Group $group) {
            $group->item('admin.sidebar.coupons', function (Item $item) {
                $item->icon('bx bxs-coupon');
                $item->weight(20);
                $item->route('admin.coupons.index');
                $item->authorize(
                    $this->auth->can('admin.coupons.index')
                );
            });
        });
    }
}