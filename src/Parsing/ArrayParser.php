<?php

namespace PHPSoda\Parsing;

use PHPSoda\Container\Container;
use PHPSoda\Container\ContainerInterface;

/**
 * Class ArrayParser
 *
 * @package PHPSoda\Parsing
 */
class ArrayParser extends Parser
{
    /**
     * @inheritDoc
     */
    public static function parse(string $file): ContainerInterface
    {
        return new Container(require "$file");
    }
}
