<?php

namespace Modules\Meal\Sidebar;

use Prgayman\Sidebar\Group;
use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Menu;
use Modules\Dashboard\Ui\Sidebar\BaseSidebarExtender;

class AdminSidebarExtender extends BaseSidebarExtender
{


    public function extend(Menu $menu)
    {
        $menu->group('admin.sidebar.menu', function (Group $group) {
            $group->item('admin.sidebar.meals', function (Item $item) {
                $item->weight(5);
                $item->icon('mdi mdi-food');


                $item->authorize(
                    $this->auth->canAny(['admin.dining_periods.index', 'admin.menus.index', 'admin.meals.index', 'admin.ingredients.index', 'admin.categories.index'])
                );

                // Menus Item
                $item->item('admin.sidebar.menus', function (Item $item) {
                    $item->weight(4);
                    $item->route('admin.menus.index');
                    $item->authorize(
                        $this->auth->can('admin.menus.index')
                    );
                });

                // Meals Item
                $item->item('admin.sidebar.meals', function (Item $item) {
                    $item->weight(4);
                    $item->route('admin.meals.index');
                    $item->authorize(
                        $this->auth->can('admin.meals.index')
                    );
                });
                // Dining Periods Item
                $item->item('admin.sidebar.dining_periods', function (Item $item) {
                    $item->weight(2);
                    $item->route('admin.dining_periods.index');
                    $item->authorize(
                        $this->auth->can('admin.dining_periods.index')
                    );
                });

                // Ingredients Item
                $item->item('admin.sidebar.ingredients', function (Item $item) {
                    $item->weight(3);
                    $item->route('admin.ingredients.index');
                    $item->authorize(
                        $this->auth->can('admin.ingredients.index')
                    );
                });
            });
        });
    }
}
