<?php

namespace Modules\Meal\Admin;

use Modules\Dashboard\Ui\Tabs\Tab;
use Modules\Dashboard\Ui\Tabs\Tabs;


class MenuTabs extends Tabs
{
    public function make()
    {
        $this->add($this->general());
    }

    private function general()
    {
        return tap(new Tab('general', 'General', __('admin.menus.tabs.general')), function (Tab $tab) {
            $tab->active()
                ->translationFields('name')
                ->fields(['name', 'is_active', 'is_default'])
                ->data([]);
        });
    }
}
