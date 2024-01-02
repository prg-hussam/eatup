<?php

namespace Modules\Meal\Admin;

use Modules\Category\Entities\Category;
use Modules\Dashboard\Ui\Tabs\Tab;
use Modules\Dashboard\Ui\Tabs\Tabs;
use Modules\Meal\Entities\Ingredient;
use Modules\Meal\Entities\Menu;
use Modules\Meal\Enums\MealType;
use Modules\Meal\Enums\MealUnit;

class MealTabs extends Tabs
{
    public function make()
    {
        $this->add($this->general())
            ->add($this->calories())
            ->add($this->thumbnail());
    }

    private function general()
    {

        return tap(new Tab('general', 'General', __('admin.meals.tabs.general')), function (Tab $tab) {
            $tab->active()
                ->translationFields('name')
                ->fields(['name', 'type', 'unit', 'min_qty', 'menus', 'max_qty', 'is_active', 'ingredients', 'categories', 'diningPeriods'])
                ->data([
                    'types' => MealType::toArrayWithTranslations(),
                    'units' => MealUnit::toArrayWithTranslations(),
                    'categories' => Category::list(),
                    'ingredients' => Ingredient::list(),
                    'menus' => Menu::list()
                ]);
        });
    }

    private function calories()
    {
        return tap(new Tab('calories', 'Calories', __('admin.meals.tabs.calories')), function (Tab $tab) {
            $tab
                ->fields(['protein_calories_per_unit', 'carbs_calories_per_unit', 'fat_calories_per_unit', 'sugars_calories_per_unit'])
                ->data([]);
        });
    }

    private function thumbnail()
    {
        return tap(new Tab('thumbnail', 'Thumbnail', __('admin.meals.tabs.thumbnail')), function (Tab $tab) {
            $tab->fields(['files.thumbnail']);
        });
    }
}
