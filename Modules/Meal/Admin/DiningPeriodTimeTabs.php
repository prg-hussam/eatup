<?php

namespace Modules\Meal\Admin;

use Modules\Dashboard\Ui\Tabs\Tab;
use Modules\Dashboard\Ui\Tabs\Tabs;
use Modules\Meal\Entities\DiningPeriod;

class DiningPeriodTimeTabs extends Tabs
{
    public function make()
    {
        $this->add($this->general());
    }

    private function general()
    {
        return tap(new Tab('general', 'General', __('admin.dining_period_times.tabs.general')), function (Tab $tab) {
            $tab->active()
                ->data([
                    'diningPeriods' => DiningPeriod::list()
                ])
                ->fields(['from', 'to', 'is_active', 'dining_period_id']);
        });
    }
}
