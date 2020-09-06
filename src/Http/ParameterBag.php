<?php

namespace PHPSoda\Http;

use PHPSoda\Container\Container;

/**
 * Class ParameterBag
 * @package PHPSoda\Http
 */
class ParameterBag extends Container
{
    /**
     * ParameterBag constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);
    }
}
