<?php

namespace Modules\Localization\Sidebar;

use Modules\Dashboard\Ui\Sidebar\BaseSidebarExtender;
use Prgayman\Sidebar\Group;
use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Menu;

class AdminSidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group('admin.sidebar.system', function (Group $group) {
            $group->item('admin.sidebar.localization', function (Item $item) {
                $item->weight(1);
                $item->icon('bx bx-globe');
                $item->authorize(
                    $this->auth->canAny([
                        'admin.provinces.index',
                        'admin.cities.index',
                    ])
                );

                // provinces item
                $item->item('admin.sidebar.provinces', function (Item $item) {
                    $item->route('admin.provinces.index');
                    $item->weight(1);
                    $item->authorize(
                        $this->auth->can('admin.provinces.index')
                    );
                });

                // cities item
                $item->item('admin.sidebar.cities', function (Item $item) {
                    $item->route('admin.cities.index');
                    $item->weight(1);
                    $item->authorize(
                        $this->auth->can('admin.cities.index')
                    );
                });
            });
        });
    }
}