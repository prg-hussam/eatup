<?php

namespace Prgayman\Sidebar\Domain;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use Prgayman\Sidebar\Exceptions\LogicException;
use Prgayman\Sidebar\Group;
use Prgayman\Sidebar\Traits\AuthorizableTrait;
use Prgayman\Sidebar\Traits\CacheableTrait;
use Prgayman\Sidebar\Traits\CallableTrait;
use Prgayman\Sidebar\Traits\ItemableTrait;

class DefaultGroup implements Group
{
    use CallableTrait, CacheableTrait, ItemableTrait, AuthorizableTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $weight = 0;

    /**
     * @var bool
     */
    protected $heading = true;

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
        'items',
        'weight',
        'heading',
    ];

    /**
     * @param  Container  $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->items = new Collection();
    }

    /**
     * @param  string  $name
     * @return Group
     */
    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  int  $weight
     * @return Group
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
     * @param  bool  $hide
     * @return Group
     */
    public function hideHeading($hide = true)
    {
        $this->heading = ! $hide;

        return $this;
    }

    /**
     * @return bool
     */
    public function shouldShowHeading()
    {
        return $this->heading ? true : false;
    }

    /** {@inheritDoc} */
    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'should_show_heading' => $this->shouldShowHeading(),
        ];
    }
}
