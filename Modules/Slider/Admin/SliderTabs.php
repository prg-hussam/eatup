<?php

namespace Modules\Slider\Admin;

use Modules\Dashboard\Ui\Tabs\Tab;
use Modules\Dashboard\Ui\Tabs\Tabs;

class SliderTabs extends Tabs
{
    public function make()
    {
        $this->add($this->slides())
            ->add($this->settings());
    }

    private function settings()
    {
        return tap(new Tab('settings', 'Settings', __('admin.sliders.tabs.settings')), function (Tab $tab) {
            $tab->translationFields('name')
                ->fields([]);
        });
    }

    private function slides()
    {
        return tap(new Tab('slides', 'Slides', __('admin.sliders.tabs.slides')), function (Tab $tab) {
            $tab->active()
                ->translationFields(['slides.*.files.banner'], '_')
                ->fields(
                    "slides",
                    "slides.*.position",
                    "slides.*.files"
                );
        });
    }
}