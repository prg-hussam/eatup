<?php

namespace Prgayman\Sidebar;

use Illuminate\Contracts\Support\Arrayable;

interface Badge extends Authorizable, Arrayable
{
    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param  mixed  $value
     * @return Badge
     */
    public function setValue($value);

    /**
     * @return string
     */
    public function getClass();

    /**
     * @param  string  $class
     * @return Badge
     */
    public function setClass($class);
}
