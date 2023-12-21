<?php

namespace Modules\Setting\Traits;

trait HasSetting
{
    /**
     * Get / set the specified setting value.
     *
     * If an array is passed, we'll assume you want to set settings.
     *
     * @param  string|array  $key
     * @param  mixed  $default
     * @return mixed|\Modules\Setting\Repositories\SettingRepository
     */
    public function setting($key = null, $default = null)
    {
        return setting($key, $default, "{$this->getTable()}:{$this->{$this->getKeyName()}}");
    }

    /**
     * Get all settings for entity
     *
     * @return array
     */
    public function getSettingsAttribute(): array
    {
        return $this->setting()->all();
    }
}
