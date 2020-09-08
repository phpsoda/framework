<?php

namespace PHPSoda\Parsing;

use PHPSoda\Container\ContainerInterface;

/**
 * Class Parser
 *
 * @package PHPSoda\Parsing
 */
abstract class Parser
{
    /**
     * Parser constructor.
     */
    private function __construct() {}

    /**
     * @param string $file
     * @return ContainerInterface
     */
    abstract public static function parse(string $file): ContainerInterface;
}
