<?php

namespace Modules\Dashboard\Ui\Tabs;

use Illuminate\Contracts\Support\Arrayable;

abstract class Tabs implements Arrayable
{
    /**
     * Array of all tabs.
     *
     * @var array
     */
    protected $tabs = [];

    /**
     * Make new tabs with groups.
     *
     * @return void
     */
    abstract public function make();

    /**
     * Add new tab.
     *
     * @param  \Modules\Dashboard\Ui\Tabs\Tab|null  $tab
     * @return self
     */
    public function add(?Tab $tab = null): self
    {
        if (! is_null($tab)) {
            $this->tabs[] = $tab;
        }

        return $this;
    }

    /**
     * Get sorted tabs.
     *
     * @return array
     */
    protected function getSortedTabs(): array
    {
        return collect($this->tabs)
            ->sortBy(function (Tab $tab) {
                return $tab->getWeight();
            })->all();
    }

    /** {@inheritDoc} */
    public function toArray()
    {
        return [
            'name' => class_basename($this),
            'tabs' => $this->tabs,
        ];
    }
}
