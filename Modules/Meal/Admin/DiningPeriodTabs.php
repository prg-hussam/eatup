<?php

namespace Modules\Meal\Admin;

use Modules\Category\Entities\Category;
use Modules\Dashboard\Ui\Tabs\Tab;
use Modules\Dashboard\Ui\Tabs\Tabs;

class DiningPeriodTabs extends Tabs
{
    public function make()
    {
        $this->add($this->general())
            ->add($this->icon());
    }

    private function general()
    {
        return tap(new Tab('general', 'General', __('admin.dining_periods.tabs.general')), function (Tab $tab) {
            $tab->active()
                ->translationFields('name')
                ->fields(['name', 'is_active', 'categories'])
                ->data([
                    'categories' => Category::list()
                ]);
        });
    }

    private function icon()
    {
        return tap(new Tab('icon', 'Icon', __('admin.dining_periods.tabs.icon')), function (Tab $tab) {
            $tab->fields(['files.icon']);
        });
    }
}
