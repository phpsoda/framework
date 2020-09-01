<?php

namespace PHPSoda\Dependency;

use ReflectionClass;
use ReflectionParameter;

class Inspector
{
    /**
     * @var string
     */
    private $class;

    /**
     * Resolver constructor.
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * @return ReflectionParameter[]
     */
    public function parameters()
    {
        $reflectionClass = new ReflectionClass($this->class);
        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor)) {
            return [];
        }

        /**
         * @var ReflectionParameter
         */
        $parameters = $constructor->getParameters();
        $result = [];

        foreach ($parameters as $parameter) {
            $result[$parameter->getName()] = $parameter->hasType() ? $parameter->getClass()->name : null;
        }

        return $result;
    }
}
