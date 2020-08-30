<?php

namespace PHPSoda\Helpers;

/**
 * Class StringHelper
 * @package PHPSoda\Helpers
 */
abstract class StringHelper
{
    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function contains(string $haystack, string $needle)
    {
        return strstr($haystack, $needle) !== false;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function startsWith(string $haystack, string $needle)
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function endsWith(string $haystack, string $needle)
    {
        return substr($haystack, strlen($haystack) - strlen($needle)) === $needle;
    }
}