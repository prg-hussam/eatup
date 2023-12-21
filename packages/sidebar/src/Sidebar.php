<?php

namespace Prgayman\Sidebar;

interface Sidebar
{
    /**
     * Build your sidebar implementation here
     */
    public function build();

    /**
     * @return Menu
     */
    public function getMenu();
}
