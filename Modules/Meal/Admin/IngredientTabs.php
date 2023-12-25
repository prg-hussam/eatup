<?php

namespace Modules\Meal\Admin;

use Modules\Dashboard\Ui\Tabs\Tab;
use Modules\Dashboard\Ui\Tabs\Tabs;

class IngredientTabs extends Tabs
{
    public function make()
    {
        $this->add($this->general())
            ->add($this->icon());
    }

    private function general()
    {
        return tap(new Tab('general', 'General', __('admin.ingredients.tabs.general')), function (Tab $tab) {
            $tab->active()
                ->translationFields('name')
                ->fields(['name', 'is_active'])
                ->data([]);
        });
    }


    private function icon()
    {
        return tap(new Tab('icon', 'Icon', __('admin.ingredients.tabs.icon')), function (Tab $tab) {
            $tab->fields(['files.icon']);
        });
    }
}