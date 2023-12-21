<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;
use Modules\Setting\Events\SettingSaved;
use Modules\Support\Eloquent\Model;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'is_translatable', 'group', 'payload'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_translatable' => 'boolean',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => SettingSaved::class,
    ];

    /**
     * Get all settings with cache support.
     *
     * @param  string  $group
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function allCached(string $group = 'system')
    {
        return Cache::rememberForever(md5(strtolower("settings.all:{$group}:" . locale())), function () use ($group) {
            return self::where('group', $group)->get()->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->payload];
            });
        });
    }

    /**
     * Determine if the given setting key exists.
     *
     * @param  string  $key
     * @param  string  $group
     * @return bool
     */
    public static function has($key, $group = 'system'): bool
    {
        return static::where('group', $group)->where('key', $key)->exists();
    }

    /**
     * Get setting for the given key.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @param  string  $default
     * @return string|array
     */
    public static function get(string $key, $default = null, ?string $group = null)
    {
        return static::where('group', $group ?: 'system')
            ->where('key', $key)
            ->first()
            ->payload ?? $default;
    }

    /**
     * Set the given setting.
     *
     * @param  string  $key
     * @param  mixed  $payload
     * @return void
     */
    public static function set(string $key, $payload, string $group = 'system')
    {
        if ($key === 'translatable') {
            return static::setTranslatableSettings($payload);
        }

        static::updateOrCreate(['key' => $key, 'group' => $group], ['payload' => $payload]);
    }

    /**
     * Set a translatable settings.
     *
     * @param  array  $settings
     * @param  string  $group
     * @return void
     */
    public static function setTranslatableSettings($settings = [], string $group = 'system')
    {
        foreach ($settings as $key => $payload) {
            $oldSetting = static::where('group', $group ?? 'system')
                ->where('key', $key)
                ->first();

            $oldPayload = $oldSetting ? unserialize($oldSetting->getRawOriginal('payload')) : null;
            $oldPayload = is_array($oldPayload) ? $oldPayload : [];

            static::updateOrCreate(['key' => $key, 'group' => $group], [
                'is_translatable' => true,
                'payload' =>  array_merge($oldPayload, [locale() => $payload]),
            ]);
        }
    }

    /**
     * Set the given settings.
     *
     * @param  array  $settings
     * @param  string  $group
     * @return void
     */
    public static function setMany($settings, $group = 'system')
    {
        foreach ($settings as $key => $payload) {
            self::set($key, $payload, $group);
        }
    }

    /**
     * Set the payload of the setting.
     *
     * @param  mixed  $payload
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function payload(): Attribute
    {
        return Attribute::make(
            set: fn ($payload) => serialize($payload),
            get: function ($payload) {
                $payload = unserialize($payload);

                if ($this->is_translatable) {
                    $fallbackLocale = fallback_locale();
                    $payload = isset($payload[locale()])
                        ? $payload[locale()]
                        : (isset($payload[$fallbackLocale])
                            ? $payload[$fallbackLocale]
                            : null);
                }

                return $payload;
            }
        );
    }
}
