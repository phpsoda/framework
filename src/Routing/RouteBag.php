<?php

namespace PHPSoda\Routing;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use PHPSoda\Http\Request;
use Traversable;

/**
 * Class RouteBag
 * @package PHPSoda\Routing
 */
class RouteBag implements IteratorAggregate, Countable
{
    /**
     * @var Route[]
     */
    protected $routes;

    /**
     * RouteBag constructor.
     * @param Route[] $routes
     */
    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function hasByRequest(Request $request)
    {
        foreach ($this->routes as $route) {
            if ($route->checkByRequest($request)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $path
     * @param string $method
     * @return bool
     */
    public function hasByPathAndMethod(string $path, string $method)
    {
        foreach ($this->routes as $route) {
            if ($route->checkByPathAndMethod($path, $method)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Request $request
     * @return Route|null
     */
    public function getByRequest(Request $request)
    {
        foreach ($this->routes as $route) {
            if ($route->checkByRequest($request)) {
                return $route;
            }
        }

        return null;
    }

    /**
     * @param string $path
     * @param string $method
     * @return Route|null
     */
    public function getByPathAndMethod(string $path, string $method)
    {
        foreach ($this->routes as $route) {
            if ($route->checkByPathAndMethod($path, $method)) {
                return $route;
            }
        }

        return null;
    }

    /**
     * @param Route $route
     * @return $this
     */
    public function add(Route $route)
    {
        $this->routes[] = $route;

        return $this;
    }

    /**
     * @return ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->routes);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->routes);
    }

    /**
     * @return Route[]
     */
    public function toArray()
    {
        return $this->routes;
    }
}
