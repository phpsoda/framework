<?php

namespace PHPSoda\Dependency;

use ReflectionClass;
use ReflectionException;

/**
 * Class Inspector
 * @package PHPSoda\Dependency
 */
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
     * @return Parameter[]
     * @throws ReflectionException
     */
    public function parameters()
    {
        $reflectionClass = new ReflectionClass($this->class);
        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor)) {
            return [];
        }

        $parameters = $constructor->getParameters();
        $result = [];

        foreach ($parameters as $parameter) {
            $result[] = new Parameter(
                $parameter->getName(),
                $parameter->getType() ? new ParameterType($parameter->getType(), $parameter->getType()->isBuiltin()) : null,
                $parameter->isOptional()
            );
        }

        return $result;
    }

    /**
     * @return Parameter[]
     * @throws ReflectionException
     */
    public function noneOptionalParameters()
    {
        return array_filter($this->parameters(), function ($parameter) {
            return !$parameter->isOptional();
        });
    }
}
