<?php

namespace Prgayman\Sidebar\Infrastructure;

interface SidebarFlusher
{
    /**
     * Flush
     *
     * @param $name
     */
    public function flush($name);
}
