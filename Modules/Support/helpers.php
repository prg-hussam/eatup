<?php

use Carbon\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Support\Enums\DateTimeFormatCases;
use Modules\Support\RTLDetector;
use Illuminate\Support\Facades\Cache;
use Modules\Media\Entities\File;

if (!function_exists('locale')) {
    /**
     * Get current locale.
     *
     * @return string
     */
    function locale()
    {
        return app()->getLocale();
    }
}

if (!function_exists('fallback_locale')) {
    /**
     * Get fallback locale.
     *
     * @return string
     */
    function fallback_locale()
    {
        return config('app.fallback_locale');
    }
}

if (!function_exists('supported_locales')) {
    /**
     * Get all supported locales.
     *
     * @return array
     */
    function supported_locales()
    {
        return LaravelLocalization::getSupportedLocales();
    }
}

if (!function_exists('non_localized_url')) {
    /**
     * It returns an URL without locale.
     *
     * @param  string  $url
     * @return string
     */
    function non_localized_url($url = null)
    {
        return LaravelLocalization::getNonLocalizedURL($url);
    }
}

if (!function_exists('is_multilingual')) {
    /**
     * Determine if the app has multi language.
     *
     * @return bool
     */
    function is_multilingual()
    {
        return count(supported_locales()) > 1;
    }
}

if (!function_exists('supported_locale_keys')) {
    /**
     * Get all supported locale keys.
     *
     * @return array
     */
    function supported_locale_keys()
    {
        return LaravelLocalization::getSupportedLanguagesKeys();
    }
}

if (!function_exists('localized_url')) {
    /**
     * Returns an URL adapted to the given locale.
     *
     * @param  string  $locale
     * @param  string  $url
     * @return string
     */
    function localized_url($locale, $url = null)
    {
        return LaravelLocalization::getLocalizedURL($locale, $url);
    }
}

if (!function_exists('slugify')) {
    /**
     * Generate a URL friendly "slug" from a given string
     *
     * @param  string  $value
     */
    function slugify($value)
    {
        $slug = preg_replace('/[\s<>[\]{}|\\^%&\$,\/:;=?@#\'\"]/', '-', mb_strtolower($value));

        // Remove duplicate separators.
        $slug = preg_replace('/-+/', '-', $slug);

        // Trim special characters from the beginning and end of the slug.
        return trim($slug, '!"#$%&\'()*+,-./:;<=>?@[]^_`{|}~');
    }
}

if (!function_exists('isRtl')) {
    /**
     * Determine if the given / current locale is RTL script.
     *
     * @param  string|null  $locale
     * @return bool
     */
    function isRtl($locale = null)
    {
        return RTLDetector::detect($locale ?: locale());
    }
}

if (!function_exists('dateTimeFormat')) {
    /**
     * System date and time format
     *
     * @param  \Carbon\Carbon  $date
     * @param  \Modules\Support\Enums\DateTimeFormatCases  $case
     * @return string
     */
    function dateTimeFormat(Carbon $date, DateTimeFormatCases $case = DateTimeFormatCases::Date): string
    {
        switch ($case) {
            case DateTimeFormatCases::DateTime:
                return $date->format(setting('default_dateformat', 'Y-m-d') . ' h:i A');
            case DateTimeFormatCases::Time:
                return $date->format('h:i A');
            case DateTimeFormatCases::Date:
                return $date->format(setting('default_dateformat', 'Y-m-d'));
        }
    }
}


if (!function_exists('humanFileSize')) {
    /**
     * Get human readable file size.
     *
     * @param int $bytes
     * @param int $decimals
     * @return string
     */
    function humanFileSize($size, $precision = 2)
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $step = 1024;
        $i = 0;
        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }
        return round($size, $precision) . ' ' . $units[$i];
    }
}

if (!function_exists('getMedia')) {
    /**
     * Get system media
     *
     * @param int $fileId
     */
    function getMedia($fileId)
    {
        return Cache::rememberForever(md5("files.{$fileId}"), function () use ($fileId) {
            return File::findOrNew($fileId);
        });
    }
}

if (!function_exists('getCopyrightText')) {
    /**
     * Get copy right text
     *
     * @return string
     */
    function getCopyrightText()
    {
        return strtr(setting('copyright_text', ''), [
            '{{ platform_url }}' => config('app.url'),
            '{{ platform_name }}' => setting('app_name'),
            '{{ year }}' => date('Y'),
        ]);
    }
}
