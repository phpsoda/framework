<?php

namespace PHPSoda\Dependency;

use Exception;
use PHPSoda\Container\Container;
use ReflectionException;

/**
 * Class AutoBuilder
 *
 * @package PHPSoda\Dependency
 */
abstract class AutoBuilder extends Container
{
    /**
     * @param string $class
     * @return mixed|null
     * @throws ReflectionException
     * @throws Exception
     */
    public function build(string $class)
    {
        if (!class_exists($class)) {
            throw new Exception("$class class not found!");
        }

        if ($this->has($class)) {
            return $this->get($class);
        }

        $inspector = new Inspector($class);

        $parameters = $inspector->noneOptionalParameters();

        if (count($parameters) === 0) {
            return new $class();
        }

        $arguments = [];

        foreach ($parameters as $parameter) {
            if ($parameter->hasType() && !$parameter->getType()->isBuiltin()) {
                if ($this->has($parameter->getType())) {
                    $arguments[] = $this->get($parameter->getType());
                } else {
                    $arguments[] = $this->build($parameter->getType());
                }
            } else {
                $arguments[] = $this->get($parameter->getName());
            }
        }

        return new $class(...$arguments);
    }
}
