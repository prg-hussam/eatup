<?php

namespace Modules\Support\Traits;

trait EnumArrayable
{
    /**
     * @return array
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return array
     */
    public static function toArray(): array
    {
        return array_combine(self::values(), self::names());
    }

    /**
     *
     * @param string $transKey
     * @return array
     */
    public static function toArrayWithTranslations(string $transKey = "enums", array $except = []): array
    {
        $cases = [];

        foreach (self::values() as $value) {
            if (!in_array($value, $except)) {
                $cases[$value] =  __("{$transKey}.{$value}");
            }
        }

        return $cases;
    }
}