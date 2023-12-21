<?php

namespace Modules\Support\Traits;

use Illuminate\Support\Facades\Cache;

trait HasClearCache
{
    public static function registerClearCacheOnEvents()
    {
        static::saved(function ($entity) {
            $entity->clearEntityTaggedCache();
        });

        static::deleted(function ($entity) {
            $entity->clearEntityTaggedCache();
        });
    }

    public function clearEntityTaggedCache()
    {
        Cache::tags($this->getTable())->flush();
    }
}
