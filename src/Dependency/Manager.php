<?php

namespace PHPSoda\Dependency;

use Exception;
use PHPSoda\Application;

class Manager
{
    /**
     * @var Application
     */
    private $app;

    /**
     * Manager constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $class
     * @throws Exception
     */
    public function resolve(string $class)
    {
        if (!class_exists($class)) {
            throw new Exception("$class class not found!");
        }

        if ($this->app->has($class)) {
            return $this->app->get($class);
        }

        $inspector = new Inspector($class);

        $parameters = $inspector->noneOptionalParameters();

        if (count($parameters) === 0) {
            return new $class();
        }

        $arguments = [];

        foreach ($parameters as $parameter) {
            if ($parameter->hasType() && !$parameter->getType()->isBuiltin()) {
                if ($this->app->has($parameter->getType())) {
                    $arguments[] = $this->app->get($parameter->getType());
                } else {
                    $arguments[] = $this->resolve($parameter->getType());
                }
            } else {
                $arguments[] = $this->app->get($parameter->getName());
            }
        }

        return new $class(...$arguments);
    }
}
