<?php

namespace PHPSoda\Helpers;

/**
 * Class StringHelper
 *
 * @package PHPSoda\Helpers
 */
abstract class StringHelper
{
    const REGEX_DELIMITER = '#';

    /**
     * @param string $patter
     * @return string
     */
    public static function wrapPattern(string $patter): string
    {
        return self::REGEX_DELIMITER . trim($patter, self::REGEX_DELIMITER) . self::REGEX_DELIMITER;
    }

    /**
     * @param string $pattern
     * @param string $input
     * @return bool
     */
    public static function matches(string $pattern, string $input): bool
    {
        preg_match(self::wrapPattern($pattern), $input, $matches);

        return count($matches) > 0;
    }

    /**
     * @param string $pattern
     * @param string $input
     * @return bool
     */
    public static function equals(string $pattern, string $input): bool
    {
        return self::matches('^' . $pattern . '$', $input);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function contains(string $haystack, string $needle): bool
    {
        return self::matches($needle, $haystack);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function startsWith(string $haystack, string $needle): bool
    {
        return self::matches('^' . $needle, $haystack);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function endsWith(string $haystack, string $needle): bool
    {
        return self::matches($needle . '$', $haystack);
    }

    /**
     * @param string $pattern
     * @param string $replacement
     * @param string $input
     * @return string|string[]|null
     */
    public static function replace(string $pattern, string $replacement, string $input)
    {
        return preg_replace(self::wrapPattern($pattern), $replacement, $input);
    }
}
