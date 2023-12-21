<?php

namespace Modules\Dashboard\Ui\Sidebar;

use Prgayman\Sidebar\Presentation\SidebarRenderer;

class AdminSidebarRenderer
{
    /**
     * @var \Modules\Dashboard\Sidebar\AdminSidebar
     */
    protected $sidebar;

    /**
     * @var \Maatwebsite\Sidebar\Presentation\SidebarRenderer
     */
    protected $renderer;

    /**
     * @param  \Modules\Dashboard\Sidebar\AdminSidebar  $sidebar
     * @param  \Prgayman\Sidebar\Presentation\SidebarRenderer  $renderer
     */
    public function __construct(AdminSidebar $sidebar, SidebarRenderer $renderer)
    {
        $this->sidebar = $sidebar;
        $this->renderer = $renderer;
    }

    /**
     * Render admin sidebar
     */
    public function render(): array
    {
        return $this->renderer->render($this->sidebar);
    }
}
