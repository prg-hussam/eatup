<?php

namespace Modules\Localization\Admin;

use Modules\Dashboard\Ui\Tabs\Tab;
use Modules\Dashboard\Ui\Tabs\Tabs;
use Modules\Localization\Entities\Province;

class CityTabs extends Tabs
{
    public function make()
    {
        $this->add($this->general());
    }

    private function general()
    {
        return tap(new Tab('general', 'General', __('admin.cities.tabs.general')), function (Tab $tab) {
            $tab->active()
                ->translationFields('name')
                ->fields(['name', 'province_id', 'is_active'])
                ->data([
                    'provinces' => Province::list()
                ]);
        });
    }
}