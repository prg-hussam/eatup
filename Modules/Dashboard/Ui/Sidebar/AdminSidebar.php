<?php

namespace Modules\Dashboard\Ui\Sidebar;

use Nwidart\Modules\Facades\Module;
use Prgayman\Sidebar\Menu;
use Prgayman\Sidebar\Sidebar;

class AdminSidebar implements Sidebar
{
    /**
     * The menu instance.
     *
     * @var \Prgayman\Sidebar\Menu
     */
    protected $menu;

    /**
     * Create a new sidebar instance.
     *
     * @param  \Prgayman\Sidebar\Menu  $menu
     * @return void
     */
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Get the built menu.
     *
     * @return \Prgayman\Sidebar\Menu
     */
    public function getMenu()
    {
        $this->build();

        return $this->menu;
    }

    /**
     * Build the sidebar menu.
     *
     * @return void
     */
    public function build()
    {
        $this->addModuleExtenders();
    }

    /**
     * Add all enabled modules sidebar extender.
     *
     * @return void
     */
    private function addModuleExtenders()
    {
        foreach (Module::allEnabled() as $module) {
            $this->add("Modules\\{$module->getName()}\\Sidebar\\AdminSidebarExtender");
        }
    }

    /**
     * Add sidebar extender to the menu.
     *
     * @param  string  $extender
     * @return void
     */
    private function add($extender)
    {
        if (class_exists($extender)) {
            resolve($extender)->extend($this->menu);
        }

        $this->menu->add($this->menu);
    }
}
