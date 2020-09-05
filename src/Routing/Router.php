<?php

namespace PHPSoda\Routing;

use PHPSoda\Application;
use PHPSoda\Dependency\Manager;
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
     */
    public function __construct()
    {
        $this->routes = new RouteBag([]);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function handle(Request $request): Response
    {
        $this->currentRoute = $this->routes->getByRequest($request);

        if ($this->currentRoute !== null) {
            $dependencyManager = new Manager(Application::getInstance());

            $controller = $dependencyManager->resolve($this->currentRoute->getControllerName());
            $action = $this->currentRoute->getActionName();

            if (!method_exists($controller, $action)) {
                return new JsonResponse([
                    'message' => "Action not found!",
                ], 404);
            }

            foreach ($this->currentRoute->getGateNames() as $gateName) {
                $gate = $dependencyManager->resolve($gateName);

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

    /**
     * @param string $path
     * @param string $handler
     * @param array|string[] $methods
     * @param array $gates
     * @return Route
     */
    public static function createRoute(
        string $path = Route::DEFAULT_PATH,
        string $handler = Route::DEFAULT_CONTROLLER,
        array $methods = Route::DEFAULT_METHODS,
        array $gates = []
    )
    {
        $route = new Route($path, $handler, $methods, $gates);

        return $route;
    }

    /**
     * @param string $path
     * @param string $handler
     * @param array $gates
     * @return Route
     */
    public static function get(
        string $path = Route::DEFAULT_PATH,
        string $handler = Route::DEFAULT_CONTROLLER,
        array $gates = []
    )
    {
        return self::createRoute($path, $handler, ['GET'], $gates);
    }

    /**
     * @param string $path
     * @param string $handler
     * @param array $gates
     * @return Route
     */
    public static function post(
        string $path = Route::DEFAULT_PATH,
        string $handler = Route::DEFAULT_CONTROLLER,
        array $gates = []
    )
    {
        return self::createRoute($path, $handler, ['POST'], $gates);
    }

    /**
     * @param string $path
     * @param string $handler
     * @param array $gates
     * @return Route
     */
    public static function put(
        string $path = Route::DEFAULT_PATH,
        string $handler = Route::DEFAULT_CONTROLLER,
        array $gates = []
    )
    {
        return self::createRoute($path, $handler, ['PUT'], $gates);
    }

    /**
     * @param string $path
     * @param string $handler
     * @param array $gates
     * @return Route
     */
    public static function delete(
        string $path = Route::DEFAULT_PATH,
        string $handler = Route::DEFAULT_CONTROLLER,
        array $gates = []
    )
    {
        return self::createRoute($path, $handler, ['DELETE'], $gates);
    }
}
