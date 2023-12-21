<?php

if (! function_exists('setting')) {
    /**
     * Get / set the specified setting value.
     *
     * If an array is passed, we'll assume you want to set settings.
     *
     * @param  string|array  $key
     * @param  mixed  $default
     * @param  string  $group
     * @return mixed|\Modules\Setting\Repositories\SettingRepository
     */
    function setting($key = null, $default = null, $group = 'system')
    {
        if (is_null($key)) {
            return app('setting', ['group' => $group]);
        }

        if (is_array($key)) {
            return app('setting', ['group' => $group])->set($key);
        }

        try {
            return app('setting', ['group' => $group])->get($key, $default);
        } catch (PDOException $e) {
            return $default;
        }
    }
}
