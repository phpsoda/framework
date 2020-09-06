<?php

namespace PHPSoda\Config;

use PHPSoda\Container\ContainerInterface;

/**
 * Class Config
 *
 * @package PHPSoda\Config
 */
abstract class Config
{
    /**
     * Config constructor.
     */
    private function __construct()
    {
    }

    /**
     * @param string $path
     * @return ContainerInterface
     */
    abstract public static function parse(string $path): ContainerInterface;
}
