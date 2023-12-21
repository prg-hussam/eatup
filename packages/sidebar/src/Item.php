<?php

namespace Prgayman\Sidebar;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

interface Item extends Itemable, Authorizable, Routeable, Arrayable
{
    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param  mixed  $name
     * @return Item $item
     */
    public function name($name);

    /**
     * @param  int  $weight
     * @return Item
     */
    public function weight($weight);

    /**
     * @return int
     */
    public function getWeight();

    /**
     * @return string
     */
    public function getIcon();

    /**
     * @param  string  $icon
     * @return Item
     */
    public function icon($icon);

    /**
     * @return string
     */
    public function getToggleIcon();

    /**
     * @param  string  $icon
     * @return Item
     */
    public function toggleIcon($icon);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param  string  $url
     * @return Item
     */
    public function url($url);

    /**
     * @param    $route
     * @param  array  $params
     * @return Item
     */
    public function route($route, $params = []);

    /**
     * @param  callable|null|string  $callbackOrValue
     * @param  string|null  $className
     *                                              return Badge
     */
    public function badge($callbackOrValue = null, $className = null);

    /**
     * @param  Badge  $badge
     * @return Badge
     */
    public function addBadge(Badge $badge);

    /**
     * @return Collection|Badge[]
     */
    public function getBadges();

    /**
     * @param  string  $path
     * @return $this
     */
    public function isActiveWhen($path);

    /**
     * @return string
     */
    public function getActiveWhen();

    /**
     * @param  string  $newTab
     * @return $this
     */
    public function isNewTab($newTab);

    /**
     * @return bool
     */
    public function getNewTab();
}
