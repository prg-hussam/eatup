<?php

namespace Modules\Media\Sidebar;

use Modules\Dashboard\Ui\Sidebar\BaseSidebarExtender;
use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Menu;
use Prgayman\Sidebar\Group;

class AdminSidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group('admin.sidebar.menu', function (Group $group) {
            $group->item('admin.sidebar.media', function (Item $item) {
                $item->weight(30);
                $item->icon('mdi mdi-folder-multiple-image');
                $item->route('admin.media.index');
                $item->authorize(
                    $this->auth->can('admin.media.index')
                );
            });
        });
    }
}
