<?php

namespace Modules\User\Sidebar;

use Modules\Dashboard\Ui\Sidebar\BaseSidebarExtender;
use Prgayman\Sidebar\Group;
use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Menu;

class AdminSidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group('admin.sidebar.system', function (Group $group) {
            $group->item('admin.sidebar.users', function (Item $item) {
                $item->weight(5);
                $item->icon('mdi mdi-account-group');
                $item->route('admin.users.index');

                $item->authorize(
                    $this->auth->canAny(['admin.roles.index', 'admin.users.index'])
                );

                // Users
                $item->item('admin.sidebar.users', function (Item $item) {
                    $item->weight(5);
                    $item->route('admin.users.index');
                    $item->authorize(
                        $this->auth->can('admin.users.index')
                    );
                });

                // roles
                $item->item('admin.sidebar.roles', function (Item $item) {
                    $item->weight(10);
                    $item->route('admin.roles.index');
                    $item->authorize(
                        $this->auth->can('admin.roles.index')
                    );
                });
            });
        });
    }
}
