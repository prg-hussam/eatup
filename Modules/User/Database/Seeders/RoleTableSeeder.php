<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Modules\User\Entities\Role;
use Modules\User\Repositories\PermissionRepository;
use Modules\User\Repositories\RoleRepository;
use Spatie\Permission\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Roles
        foreach (RoleRepository::all() as  $role) {
            if (!Role::where('name', $role)->first()) {
                Role::create(['name' => $role, 'guard_name' => 'web', 'display_name' => ['en' => 'Super Admin']]);
            }
        }

        // Create Permissions
        foreach (PermissionRepository::collapse() as  $permission) {
            if (!Permission::where('name', $permission)->first()) {
                Artisan::call("permission:create-permission $permission");
            }
        }
    }
}