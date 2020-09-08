<?php

namespace PHPSoda\Parsing;

use PHPSoda\Container\Container;
use PHPSoda\Container\ContainerInterface;

/**
 * Class INIParser
 *
 * @package PHPSoda\Parsing
 */
class INIParser extends Parser
{
    /**
     * @inheritDoc
     */
    public static function parse(string $file): ContainerInterface
    {
        return new Container(parse_ini_file($file, true));
    }
}
