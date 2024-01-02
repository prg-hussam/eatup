<?php

namespace Modules\Slider\Sidebar;

use Modules\Dashboard\Ui\Sidebar\BaseSidebarExtender;
use Prgayman\Sidebar\Group;
use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Menu;

class AdminSidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group('admin.sidebar.system', function (Group $group) {
            $group->item('admin.sidebar.appearance', function (Item $item) {
                $item->weight(1);
                $item->icon('mdi mdi-brush-outline');

                $item->authorize(
                    $this->auth->canAny([
                        'admin.sliders.index',
                    ])
                );

                // Sliders
                $item->item('admin.sidebar.sliders', function (Item $item) {
                    $item->weight(5);
                    $item->route('admin.sliders.index');
                    $item->authorize(
                        $this->auth->can('admin.sliders.index')
                    );
                });
            });
        });
    }
}
