<?php

namespace PHPSoda\Patterns;

/**
 * Class Singleton
 * @package PHPSoda\Patterns
 */
abstract class Singleton
{
    /**
     * @var static
     */
    protected static $instance;

    /**
     * Singleton constructor.
     */
    private function __construct()
    {
    }

    /**
     * Restrict cloning objects.
     */
    private function __clone()
    {
    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}
