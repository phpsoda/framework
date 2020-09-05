<?php

namespace PHPSoda\Routing;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use PHPSoda\Http\Request;
use Traversable;

/**
 * Class RouteBag
 * @package PHPSoda\Routing
 */
class RouteBag implements ArrayAccess, IteratorAggregate, Countable, JsonSerializable
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
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->routes);
    }

    /**
     * @param mixed $offset
     * @return mixed|Route
     */
    public function offsetGet($offset)
    {
        return $this->routes[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->routes[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->routes[$offset]);
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
     * @return mixed|Route[]
     */
    public function jsonSerialize()
    {
        return $this->routes;
    }
}
