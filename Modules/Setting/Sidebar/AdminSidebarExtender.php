<?php

namespace Modules\Setting\Sidebar;

use Modules\Dashboard\Ui\Sidebar\BaseSidebarExtender;
use Prgayman\Sidebar\Group;
use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Menu;

class AdminSidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group('admin.sidebar.system', function (Group $group) {
            $group->item('admin.sidebar.settings', function (Item $item) {
                $item->icon('mdi mdi-cog');
                $item->weight(25);
                $item->authorize(
                    $this->auth->canAny(['admin.settings.index', 'admin.activity_log.setting'])
                );
                $item->item('admin.sidebar.system_settings', function (Item $item) {
                    $item->route('admin.settings.index');
                    $item->isActiveWhen("*/settings");
                    $item->authorize(
                        $this->auth->can('admin.settings.index')
                    );
                });
            });
        });
    }
}
