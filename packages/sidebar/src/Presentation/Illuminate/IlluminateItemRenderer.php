<?php

namespace Prgayman\Sidebar\Presentation\Illuminate;

use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Presentation\ActiveStateChecker;

class IlluminateItemRenderer
{
    /**
     * @param  Item  $item
     * @return array|null
     */
    public function render(Item $item)
    {
        if ($item->isAuthorized()) {
            $items = [];
            foreach ($item->getItems() as $child) {
                $items[] = (new IlluminateItemRenderer)->render($child);
            }

            $badges = [];
            foreach ($item->getBadges() as $badge) {
                $badges[] = (new IlluminateBadgeRenderer)->render($badge);
            }

            return [
                'item' => $item->toArray(),
                'items' => array_filter($items),
                'badges' => $badges,
                'active' => (new ActiveStateChecker())->isActive($item),
            ];
        }
    }
}
