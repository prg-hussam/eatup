<?php

namespace Modules\Setting\Admin;

use Modules\Dashboard\Ui\Boxes\Box;
use Modules\Dashboard\Ui\Boxes\Boxes;
use Modules\Support\SvgIcons;

class SettingBoxes extends Boxes
{
    public function make()
    {
        $this->group('general_settings', 'admin.settings.boxes.group.general_settings')
            ->add($this->general())
            ->add($this->application())
            ->add($this->maintenance())
            ->add($this->mail());

        $this->group('appearance_settings', 'admin.settings.boxes.group.appearance_settings')
            ->add($this->logo());
    }

    private function general(): Box
    {
        return tap(new Box('general', 'admin.settings.boxes.general.name'), function (Box $box) {
            $box->description('admin.settings.boxes.general.description');
            $box->authorize($this->auth->can('admin.settings.edit'));
            $box->icon('mdi mdi-cog-outline', 'font');
            $box->url(route('admin.settings.edit', ['name' => 'general']));
        });
    }

    private function application(): Box
    {
        return tap(new Box('application', 'admin.settings.boxes.application.name'), function (Box $box) {
            $box->description(__('admin.settings.boxes.application.description'));
            $box->authorize($this->auth->can('admin.settings.edit'));
            $box->icon('mdi mdi-apps', 'font');
            $box->url(route('admin.settings.edit', ['name' => 'application']));
        });
    }

    private function maintenance(): Box
    {
        return tap(new Box('maintenance', 'admin.settings.boxes.maintenance.name'), function (Box $box) {
            $box->description('admin.settings.boxes.maintenance.description');
            $box->authorize($this->auth->can('admin.settings.edit'));
            $box->icon('mdi mdi-movie-open-cog-outline', 'font');
            $box->url(route('admin.settings.edit', ['name' => 'maintenance']));
        });
    }

    private function mail(): Box
    {
        return tap(new Box('mail', 'admin.settings.boxes.mail.name'), function (Box $box) {
            $box->description('admin.settings.boxes.mail.description');
            $box->authorize($this->auth->can('admin.settings.edit'));
            $box->icon('mdi mdi-email-fast-outline', 'font');
            $box->url(route('admin.settings.edit', ['name' => 'mail']));
        });
    }

    private function logo(): Box
    {
        return tap(new Box('logo', 'admin.settings.boxes.logo.name'), function (Box $box) {
            $box->description('admin.settings.boxes.logo.description');
            $box->authorize($this->auth->can('admin.settings.edit'));
            $box->icon('mdi mdi-select-color', 'font');
            $box->url(route('admin.settings.edit', ['name' => 'logo']));
        });
    }
}
