<?php

namespace Modules\User\Admin;

use Modules\Dashboard\Ui\Tabs\Tab;
use Modules\Dashboard\Ui\Tabs\Tabs;
use Modules\User\Repositories\PermissionRepository;

class RoleTabs extends Tabs
{
    public function make()
    {
        $this
            ->add($this->general())
            ->add($this->permissions());
    }

    private function general()
    {
        return tap(new Tab('general', 'General', __('admin.roles.tabs.general')), function (Tab $tab) {
            $tab->active()
                ->weight(0)
                ->translationFields('display_name')
                ->fields('name');
        });
    }

    private function permissions()
    {
        return tap(new Tab('permissions', 'Permissions', __('admin.roles.tabs.permissions')), function (Tab $tab) {
            $tab->weight(1)
                ->data([
                    'permissions' => PermissionRepository::grouped(),
                ]);
        });
    }
}
