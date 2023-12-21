<?php

namespace Prgayman\Sidebar\Domain;

use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use Prgayman\Sidebar\Group;
use Prgayman\Sidebar\Menu;
use Prgayman\Sidebar\Traits\AuthorizableTrait;
use Prgayman\Sidebar\Traits\CacheableTrait;
use Prgayman\Sidebar\Traits\CallableTrait;

class DefaultMenu implements Menu
{
    use CallableTrait, CacheableTrait, AuthorizableTrait;

    /**
     * @var Collection|Group[]
     */
    protected $groups;

    /**
     * @var Container
     */
    protected $container;

    /**
     * Data that should be cached
     *
     * @var array
     */
    protected $cacheables = [
        'groups',
    ];

    /**
     * @param  Container  $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->groups = new Collection();
    }

    /**
     * Init a new group or call an existing group and add it to the menu
     *
     * @param    $name
     * @param  callable  $callback
     * @return Group
     */
    public function group($name, Closure $callback = null)
    {
        if ($this->groups->has($name)) {
            $group = $this->groups->get($name);
        } else {
            $group = $this->container->make('Prgayman\Sidebar\Group');
            $group->name($name);
        }

        $this->call($callback, $group);

        $this->addGroup($group);

        return $group;
    }

    /**
     * Add a Group instance to the Menu
     *
     * @param  Group  $group
     * @return $this
     */
    public function addGroup(Group $group)
    {
        $this->groups->put($group->getName(), $group);

        return $this;
    }

    /**
     * Get collection of Group instances sorted by their weight
     *
     * @return Collection|Group[]
     */
    public function getGroups()
    {
        return $this->groups->sortBy(function (Group $group) {
            return $group->getWeight();
        });
    }

    /**
     * Add another Menu instance and combined the two
     * Groups with the same name get combined, but
     * inherit each other's items
     *
     * @param  Menu  $menu
     * @return Menu $menu
     */
    public function add(Menu $menu)
    {
        foreach ($menu->getGroups() as $group) {
            if ($this->groups->has($group->getName())) {
                $existingGroup = $this->groups->get($group->getName());

                $group->hideHeading(! $group->shouldShowHeading());

                foreach ($group->getItems() as $item) {
                    $existingGroup->addItem($item);
                }
            } else {
                $this->addGroup($group);
            }
        }

        return $this;
    }
}
