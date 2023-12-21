<?php

namespace Modules\Setting\Listeners;

use Illuminate\Support\Facades\Cache;
use Modules\Setting\Events\SettingSaved;

class ClearSettingCache
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(SettingSaved $event)
    {
        foreach (supported_locale_keys() as $locale) {
            Cache::forget(md5("settings.all:{$event->setting->group}:{$locale}"));
        }
    }
}
