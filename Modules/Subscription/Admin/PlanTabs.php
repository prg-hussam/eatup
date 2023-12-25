<?php

namespace Modules\Subscription\Admin;


use Modules\Dashboard\Ui\Tabs\Tab;
use Modules\Dashboard\Ui\Tabs\Tabs;

class PlanTabs extends Tabs
{
    public function make()
    {
        $this->add($this->general());
    }

    private function general()
    {
        return tap(new Tab('general', 'General', __('admin.plans.tabs.general')), function (Tab $tab) {
            $tab->active()
                ->translationFields('name')
                ->fields(['name', 'price', 'duration',  'is_active']);
        });
    }
}
