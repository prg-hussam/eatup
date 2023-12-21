<?php

namespace Modules\User\Admin;

use Modules\Dashboard\Ui\Tabs\Tab;
use Modules\Dashboard\Ui\Tabs\Tabs;
use Modules\User\Entities\Role;

class UserTabs extends Tabs
{
    public function make()
    {
        $this
            ->add($this->general())
            ->add($this->password());
    }

    private function general()
    {
        return tap(new Tab('general', 'General', 'admin.users.tabs.general'), function (Tab $tab) {
            $fields = ['name', 'username',  'is_active', 'email', 'roles'];
            if (!request()->routeIs('admin.users.edit')) {
                $fields[] = 'password';
            }
            $tab->active()
                ->weight(0)

                ->data([
                    'roles' => Role::list(),
                ])
                ->fields($fields);
        });
    }

    private function password()
    {
        if (!request()->routeIs('admin.users.edit')) {
            return;
        }

        return tap(new Tab('password', 'Password', 'admin.users.tabs.new_password'), function (Tab $tab) {
            $tab->weight(1)
                ->data([])
                ->fields('password');
        });
    }
}
