<?php

namespace Modules\Support;

class DateFormats
{
    /**
     * Path of the resource.
     *
     * @var string
     */
    public const RESOURCE_PATH = __DIR__ . '/Resources/dateformats.php';

    /**
     * Array of all formats.
     *
     * @var array
     */
    private static $formats;

    /**
     * Get all formats.
     *
     * @return array
     */
    public static function all()
    {
        if (is_null(self::$formats)) {
            self::$formats = require self::RESOURCE_PATH;
        }

        return self::$formats;
    }
}
