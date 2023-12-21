<?php

namespace Prgayman\Sidebar\Domain;

use Illuminate\Contracts\Container\Container;
use Prgayman\Sidebar\Badge;
use Prgayman\Sidebar\Traits\AuthorizableTrait;
use Prgayman\Sidebar\Traits\CacheableTrait;
use Prgayman\Sidebar\Traits\CallableTrait;

class DefaultBadge implements Badge
{
    use CallableTrait, CacheableTrait, AuthorizableTrait;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var mixed
     */
    protected $value = null;

    /**
     * @var string
     */
    protected $class = 'badge bg-primary';

    /**
     * @var array
     */
    protected $cacheables = [
        'value',
        'class',
    ];

    /**
     * @param  Container  $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param  mixed  $value
     * @return Badge
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param  string  $class
     * @return Badge
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /** {@inheritDoc} */
    public function toArray()
    {
        return [
            'value' => $this->getValue(),
            'class' => $this->getClass(),
        ];
    }
}
