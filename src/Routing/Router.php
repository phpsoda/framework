<?php

namespace PHPSoda\Routing;

use Closure;
use PHPSoda\Helpers\StringHelper;
use PHPSoda\Http\Request;

/**
 * Class Router
 *
 * @package PHPSoda\Routing
 */
class Router
{
    /**
     * @var Route[]
     */
    private $routes;

    /**
     * Router constructor.
     *
     * @param Route[] $routes
     */
    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
    }

    /**
     * @param Request $request
     * @return Route|null
     */
    public function match(Request $request): ?Route
    {
        foreach ($this->routes as $route) {
            if (StringHelper::equals($route->getPattern(), $request->getPath())) {
                return $route;
            }
        }

        return null;
    }

    /**
     * @param Route $route
     * @return $this
     */
    public function addRoute(Route $route): self
    {
        $this->routes[] = $route;

        return $this;
    }

    /**
     * @param string         $uri
     * @param array          $methods
     * @param Closure|string $action
     * @return Route
     */
    public function createRoute(string $uri, array $methods, $action): Route
    {
        $route = new Route($uri, $methods, $action);
        $this->addRoute($route);

        return $route;
    }

    /**
     * @param string         $uri
     * @param Closure|string $action
     * @return Route
     */
    public function get(string $uri, $action): Route
    {
        return $this->createRoute($uri, ['GET', 'HEAD'], $action);
    }

    /**
     * @param string         $uri
     * @param Closure|string $action
     * @return Route
     */
    public function post(string $uri, $action): Route
    {
        return $this->createRoute($uri, ['POST'], $action);
    }

    /**
     * @param string         $uri
     * @param Closure|string $action
     * @return Route
     */
    public function put(string $uri, $action): Route
    {
        return $this->createRoute($uri, ['PUT'], $action);
    }

    /**
     * @param string         $uri
     * @param Closure|string $action
     * @return Route
     */
    public function patch(string $uri, $action): Route
    {
        return $this->createRoute($uri, ['PATCH'], $action);
    }

    /**
     * @param string         $uri
     * @param Closure|string $action
     * @return Route
     */
    public function delete(string $uri, $action): Route
    {
        return $this->createRoute($uri, ['DELETE'], $action);
    }
}
