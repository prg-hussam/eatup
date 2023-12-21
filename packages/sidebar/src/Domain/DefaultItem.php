<?php

namespace Prgayman\Sidebar\Domain;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use Prgayman\Sidebar\Badge;
use Prgayman\Sidebar\Exceptions\LogicException;
use Prgayman\Sidebar\Item;
use Prgayman\Sidebar\Traits\AuthorizableTrait;
use Prgayman\Sidebar\Traits\CacheableTrait;
use Prgayman\Sidebar\Traits\CallableTrait;
use Prgayman\Sidebar\Traits\ItemableTrait;
use Prgayman\Sidebar\Traits\RouteableTrait;

class DefaultItem implements Item
{
    use CallableTrait, CacheableTrait, ItemableTrait, RouteableTrait, AuthorizableTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $weight = 0;

    /**
     * @var string
     */
    protected $icon = 'bx bx-radio-circle';

    /**
     * @var string
     */
    protected $toggleIcon = 'bx bx-chevron-left';

    /**
     * @var string|bool
     */
    protected $activeWhen = false;

    /**
     * @var bool
     */
    protected $newTab = false;

    /**
     * @var string
     */
    protected $itemClass = '';

    /**
     * @var Collection|Badge[]
     */
    protected $badges;

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
        'name',
        'weight',
        'url',
        'icon',
        'toggleIcon',
        'items',
        'badges',
        'authorized',
    ];

    /**
     * @param  Container  $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->items = new Collection();
        $this->badges = new Collection();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  mixed  $name
     * @return Item $item
     */
    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param  int  $weight
     * @return Item
     */
    public function weight($weight)
    {
        if (! is_int($weight)) {
            throw new LogicException('Weight should be an integer');
        }

        $this->weight = $weight;

        return $this;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param  string  $icon
     * @return Item
     */
    public function icon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string
     */
    public function getToggleIcon()
    {
        return $this->toggleIcon;
    }

    /**
     * @param  string  $icon
     * @return Item
     */
    public function toggleIcon($icon)
    {
        $this->toggleIcon = $icon;

        return $this;
    }

    /**
     * @param  callable|null|string  $callbackOrValue
     * @param  string|null  $className
     * @return Badge
     */
    public function badge($callbackOrValue = null, $className = null)
    {
        $badge = $this->container->make('Prgayman\Sidebar\Badge');

        if (is_callable($callbackOrValue)) {
            $this->call($callbackOrValue, $badge);
        } elseif ($callbackOrValue) {
            $badge->setValue($callbackOrValue);
        }

        if ($className) {
            $badge->setClass($className);
        }

        $this->addBadge($badge);

        return $badge;
    }

    /**
     * @param  Badge  $badge
     * @return Badge
     */
    public function addBadge(Badge $badge)
    {
        $this->badges->push($badge);

        return $badge;
    }

    /**
     * @return Collection|Badge[]
     */
    public function getBadges()
    {
        return $this->badges;
    }

    /**
     * @param  string  $path
     * @return $this
     */
    public function isActiveWhen($path)
    {
        // Remove unwanted chars
        $path = ltrim($path, '/');
        $path = rtrim($path, '/');
        $path = rtrim($path, '?');

        $this->activeWhen = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getActiveWhen()
    {
        return $this->activeWhen;
    }

    /**
     * @param  bool  $newTab
     * @return $this
     */
    public function isNewTab($newTab = true)
    {
        $this->newTab = $newTab;

        return $this;
    }

    /**
     * @return bool
     */
    public function getNewTab()
    {
        return $this->newTab;
    }

    /**
     * @param  string  $itemClass
     * @return $this
     */
    public function setItemClass($itemClass)
    {
        $this->itemClass = $itemClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getItemClass()
    {
        return $this->itemClass;
    }

    /** {@inheritDoc} */
    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'icon' => $this->getIcon(),
            'new_tab' => $this->getNewTab(),
            'item_class' => $this->getItemClass(),
            'url' => $this->getUrl(),
            'has_items' => $this->hasItems(),
        ];
    }
}
