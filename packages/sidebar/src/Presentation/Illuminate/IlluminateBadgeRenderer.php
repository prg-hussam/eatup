<?php

namespace Prgayman\Sidebar\Presentation\Illuminate;

use Prgayman\Sidebar\Badge;

class IlluminateBadgeRenderer
{
    /**
     * @param  Badge  $badge
     * @return array|null
     */
    public function render(Badge $badge)
    {
        if ($badge->isAuthorized()) {
            return $badge->toArray();
        }
    }
}
