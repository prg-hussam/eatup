<?php

namespace Modules\Subscription\Admin;


use Modules\Dashboard\Ui\Tabs\Tab;
use Modules\Dashboard\Ui\Tabs\Tabs;
use Modules\Meal\Entities\DiningPeriod;

class PlanTabs extends Tabs
{
    public function make()
    {
        $this->add($this->general())
            ->add($this->pricing());
    }

    private function general()
    {
        return tap(new Tab('general', 'General', __('admin.plans.tabs.general')), function (Tab $tab) {
            $tab->active()
                ->translationFields('name')
                ->fields(['name', 'duration',  'is_active']);
        });
    }
    private function pricing()
    {
        return tap(new Tab('pricing', 'Pricing', __('admin.plans.tabs.pricing')), function (Tab $tab) {
            $tab->data([
                'diningPeriods' => DiningPeriod::list()
            ])
                ->fields(['diningPeriods', 'diningPeriods.*']);
        });
    }
}