<?php

namespace Prgayman\Sidebar\Presentation\Illuminate;

use Prgayman\Sidebar\Group;

class IlluminateGroupRenderer
{
    /**
     * @param  Group  $group
     * @return array|null
     */
    public function render(Group $group)
    {
        if ($group->isAuthorized()) {
            $items = [];
            foreach ($group->getItems() as $item) {
                $items[] = (new IlluminateItemRenderer)->render($item);
            }

            return [
                'group' => $group->toArray(),
                'items' => array_filter($items),
            ];
        }
    }
}
