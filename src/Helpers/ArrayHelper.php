<?php

namespace PHPSoda\Helpers;

/**
 * Class ArrayHelper
 * @package PHPSoda\Helpers
 */
abstract class ArrayHelper
{
    /**
     * @param $key
     * @param array $array
     * @return bool
     */
    public static function hasKey($key, array $array)
    {
        return array_key_exists($key, $array);
    }

    /**
     * @param $value
     * @param array $array
     * @return bool
     */
    public static function contains($value, array $array)
    {
        return in_array($value, $array);
    }

    /**
     * @param array $array
     * @return array
     */
    public static function flatten(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, self::flatten($value));
            } else {
                $result[] = $value;
            }
        }

        return $result;
    }
}
