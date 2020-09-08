<?php

namespace PHPSoda\Parsing;

use PHPSoda\Container\Container;
use PHPSoda\Container\ContainerInterface;

/**
 * Class JSONParser
 *
 * @package PHPSoda\Parsing
 */
class JSONParser extends Parser
{
    /**
     * @inheritDoc
     */
    public static function parse(string $file): ContainerInterface
    {
        return new Container(json_decode(file_get_contents($file), true));
    }
}
