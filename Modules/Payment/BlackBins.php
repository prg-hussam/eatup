<?php

namespace Modules\Payment;

class BlackBins
{
    /**
     * Path of the resource.
     *
     * @var string
     */
    const RESOURCE_PATH = __DIR__ . '/Resources/black_bins.php';

    /**
     * Array of all locales.
     *
     * @var array
     */
    private static $bins;

    /**
     * Get all locales.
     *
     * @return array
     */
    public static function all()
    {
        if (is_null(self::$bins)) {
            self::$bins = require self::RESOURCE_PATH;
        }

        return self::$bins;
    }
}
