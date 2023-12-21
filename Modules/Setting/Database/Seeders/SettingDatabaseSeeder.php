<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Setting\Entities\Setting;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::setMany([
            'active_theme' => 'Default',
            'supported_locales' => ['en'],
            'app_email' => 'platform@email.com',
            'app_phone_number' => '00962799715191',
            'default_locale' => 'en',
            'default_timezone' => 'Asia/Amman',
            'translatable' => [
                'app_name' => 'Platform',
                'app_address' => 'Amman, Jordan',
                'copyright_text' => 'Copyright &copy; <a href="{{ platform_url }}">{{ platform_name }}</a> {{ year }}. All rights reserved.',
            ],

            'default_dateformat' => 'Y-m-d',
            'week_starts_at' => "sunday",
            'week_ends_at' => "saturday",
        ]);
    }
}
