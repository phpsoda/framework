<?php

namespace PHPSoda\Routing;

use PHPSoda\Http\JsonResponse;
use PHPSoda\Http\Request;
use PHPSoda\Http\Response;

class Router
{
    /**
     * @var RouteBag
     */
    protected $routes;
    /**
     * @var Route
     */
    protected $currentRoute;

    /**
     * Router constructor.
     * @param array $routes
     */
    public function __construct(array $routes = [])
    {
        $this->routes = new RouteBag($routes);
    }

    public function handle(Request $request): Response
    {
        $this->currentRoute = $this->routes->getByRequest($request);

        if ($this->currentRoute !== null) {
            $controllerName = $this->currentRoute->getControllerName();

            if (!class_exists($controllerName)) {
                return new JsonResponse([
                    'message' => "Controller not found!",
                ], 404);
            }

            $controller = new $controllerName();
            $action = $this->currentRoute->getActionName();

            if (!method_exists($controller, $action)) {
                return new JsonResponse([
                    'message' => "Action not found!",
                ], 404);
            }

            foreach ($this->currentRoute->getGateNames() as $gateName) {
                $gate = new $gateName();

                if (!$gate->handle($request)) {
                    return new JsonResponse([
                        'message' => "Couldn't pass {$gateName}!",
                    ], 403);
                }
            }

            return $controller->$action($request);
        }

        return new JsonResponse([
            'message' => 'Route not found!',
        ], 404);
    }

    public function getRoutes(): RouteBag
    {
        return $this->routes;
    }

    public function setRoutes(array $routes): self
    {
        $this->routes = new RouteBag();

        return $this;
    }
}
