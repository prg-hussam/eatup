<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\User;
use Modules\User\Repositories\RoleRepository;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleTableSeeder::class,
        ]);

        $user = new User;
        $user->name = 'Super Admin';
        $user->username = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt(12345678);
        $user->is_active = true;
        $user->save();

        $user->assignRole(RoleRepository::SUPER_ADMIN);
    }
}
