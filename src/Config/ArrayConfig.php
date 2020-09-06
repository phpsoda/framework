<?php

namespace PHPSoda\Config;

use PHPSoda\Container\Container;
use PHPSoda\Container\ContainerInterface;

class ArrayConfig extends Config
{
    /**
     * @inheritDoc
     */
    public static function parse(string $path): ContainerInterface
    {
        return new Container(require $path);
    }
}