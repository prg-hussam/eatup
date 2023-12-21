<?php

namespace Modules\Dashboard\Ui\Boxes;

class BoxManager
{
    /**
     * The array of all Boxes.
     *
     * @var array
     */
    private $boxes = [];

    /**
     * The array of all boxes extenders.
     *
     * @var array
     */
    private $extends = [];

    /**
     * Register a new Boxes.
     *
     * @param  string  $name
     * @param  string  $boxes
     * @return void
     */
    public function register($name, $boxes)
    {
        $this->boxes[$name] = $boxes;
    }

    /**
     * Add a new Boxes extender.
     *
     * @param  string  $name
     * @param  string  $extender
     * @return void
     */
    public function extend($name, $extender)
    {
        $this->extends[$name][] = $extender;
    }

    /**
     * Get boxes for the given name.
     *
     * @param  string  $name
     * @return \Modules\Admin\Ui\Boxes\Boxes
     */
    public function get($name)
    {
        if (!array_key_exists($name, $this->boxes)) {

            return;
        }

        return tap(resolve($this->boxes[$name]), function (Boxes $boxes) use ($name) {
            $boxes->make();

            $this->extendBoxes($boxes, \Arr::get($this->extends, $name, []));
        });
    }

    /**
     * Extend the given boxes using the given extenders.
     *
     * @param  \Modules\Admin\Ui\Boxes\Boxes  $boxes
     * @param  array  $extenders
     * @return void
     */
    private function extendBoxes(Boxes $boxes, array $extenders)
    {
        foreach ($extenders as $extender) {
            resolve($extender)->extend($boxes);
        }
    }
}