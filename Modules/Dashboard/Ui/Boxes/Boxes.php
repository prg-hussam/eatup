<?php

namespace Modules\Dashboard\Ui\Boxes;

abstract class Boxes
{
    /**
     * Array of all groups.
     *
     * @var array
     */
    protected $groups = [];

    /**
     * Current group name of the boxes.
     *
     * @var string
     */
    protected $group;

    /**
     * Array of all boxes.
     *
     * @var array
     */
    protected $boxes = [];

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public $auth;

    /**
     * Make new boxes with groups.
     *
     * @return void
     */
    abstract public function make();

    public function __construct()
    {
        $this->auth = auth()->user();
    }

    /**
     * Set group name.
     *
     * @param  string  $name
     * @param  string  $title
     * @return self
     */
    public function group($name, $title = null): self
    {
        $this->group = $name;

        if (! is_null($title)) {
            $this->groups[$name]['title'] = $title;
            $this->boxes[$this->group] = [];
        }

        return $this;
    }

    /**
     * Add new box.
     *
     * @param  \Modules\Admin\Ui\Boxes\Box|null  $box
     * @return self
     */
    public function add(Box $box): self
    {
        if (! is_null($box)) {
            $this->boxes[$this->group][] = $box;
        }

        return $this;
    }

    /**
     * Get all groups with it's options.
     *
     * @return array
     */
    protected function groups()
    {
        $groups = [];

        foreach ($this->groups as $group => $options) {
            $groups[$group] = $options;
        }

        return $groups;
    }

    /**
     * Render the boxes,
     *
     * @param  array  $data
     */
    public function render($data = [])
    {
        return [
            'boxes' => $this->boxes,
            'name' => class_basename($this),
            'groups' => $this->groups(),
            'data' => $data,
        ];
    }
}
