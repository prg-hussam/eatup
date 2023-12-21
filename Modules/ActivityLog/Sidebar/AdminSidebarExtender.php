<?php

namespace Modules\ActivityLog\Sidebar;

use Modules\Dashboard\Ui\Sidebar\BaseSidebarExtender;
use Prgayman\Sidebar\Group;
use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Menu;

class AdminSidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group('admin.sidebar.system', function (Group $group) {
            $group->item('admin.sidebar.activity_log', function (Item $item) {
                $item->weight(5);
                $item->icon('mdi mdi-history');
                $item->route('admin.activity_log.index');
                $item->authorize(
                    $this->auth->can('admin.activity_log.index')
                );
            });

            $group->item('admin.sidebar.settings', function (Item $item) {
                $item->item('admin.sidebar.activity_log_settings', function (Item $item) {
                    $item->weight(10);
                    $item->isActiveWhen("*/settings/activity-logs");
                    $item->route('admin.activity_log.settings.index');
                    $item->authorize(
                        $this->auth->can('admin.activity_log.setting')
                    );
                });
            });
        });
    }
}
