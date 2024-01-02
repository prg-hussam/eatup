<?php

namespace Modules\Payment\Sidebar;

use Modules\Dashboard\Ui\Sidebar\BaseSidebarExtender;
use Prgayman\Sidebar\Group;
use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Menu;

class PlatformSidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group(trans('sidebar.platform.system'), function (Group $group) {
            $group->item(trans('sidebar.platform.settings'), function (Item $item) {
                $item->item(trans('sidebar.platform.payment_settings'), function (Item $item) {
                    $item->weight(10);
                    $item->isActiveWhen("*/settings/payments");
                    $item->route('platform.payments.settings.index');
                    $item->authorize(
                        $this->auth->can('platform.payments.settings')
                    );
                });
            });
        });
    }
}
