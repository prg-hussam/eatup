<?php

namespace Modules\Dashboard\Ui\Sidebar;

class BaseSidebarExtender
{
    protected $auth;

    public function __construct()
    {
        $this->auth = auth()->user();
    }
}
