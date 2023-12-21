<?php

namespace Modules\Setting\Repositories;

use ArrayAccess;
use Modules\Setting\Entities\Setting;

class SettingRepository implements ArrayAccess
{
    /**
     * Collection of all settings.
     *
     * @var \Illuminate\Support\Collection
     */
    private $settings;

    /**
     * Group settings
     *
     * @var string
     */
    private $group;

    /**
     * Create a new repository instance.
     *
     * @param  \Illuminate\Support\Collection  $settings
     * @param  string  $group
     */
    public function __construct($settings, string $group = 'system')
    {
        $this->settings = $settings;
        $this->group = $group;
    }

    /**
     * Get all settings.
     *
     * @param  array  $except
     * @return array
     */
    public function all($except = [])
    {
        return $this->settings->except($except)->all();
    }

    /**
     * Get setting for the given key.
     *
     * @param  mixed  $offset
     * @param  mixed  $default
     * @return mixed
     */
    public function get(mixed $offset, mixed $default = null): mixed
    {
        return $this->settings->get($offset) ?: $default;
    }

    /**
     * Set the given settings.
     *
     * @param  array  $settings
     * @return void
     */
    public function set($settings = [])
    {
        Setting::setMany($settings, $this->group);
    }

    /**
     * Determine if an setting is exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->settings->has($offset);
    }

    /**
     * Get setting for the given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * Set a key / value setting pair.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set([$offset => $value]);
    }

    /**
     * Unset a setting by the given key.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->settings->forget($offset);
    }

    /**
     * Get setting for the given key.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function __get(mixed $offset)
    {
        return $this->offsetGet($offset);
    }

    /**
     * Set a offset / value setting pair.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function __set(mixed $offset, mixed $value)
    {
        $this->offsetSet($offset, $value);
    }
}
