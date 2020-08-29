<?php

namespace PHPSoda\Routing;

use PHPSoda\Application;
use PHPSoda\Http\Request;

/**
 * Class Route
 * @package PHPSoda\Routing
 */
class Route
{
    const CONTROLLERS_NAMESPACE = 'App\\Controllers\\';
    const GATES_NAMESPACE = 'App\\Gates\\';
    const CONTROLLER_SEPARATOR = '@';
    const DEFAULT_PATH = '/';
    const DEFAULT_CONTROLLER = 'ExampleController' . self::CONTROLLER_SEPARATOR . 'index';
    const DEFAULT_METHODS = ['GET'];

    /**
     * @var string
     */
    protected $path;
    /**
     * @var string
     */
    protected $controllerName;
    /**
     * @var string
     */
    protected $actionName;
    /**
     * @var array
     */
    protected $methods;
    /**
     * @var array
     */
    protected $gateNames;

    /**
     * Route constructor.
     * @param string $path
     * @param string $handler
     * @param array|string[] $methods
     * @param array $gates
     */
    public function __construct(
        string $path = self::DEFAULT_PATH,
        string $handler = self::DEFAULT_CONTROLLER,
        array $methods = self::DEFAULT_METHODS,
        array $gates = []
    )
    {
        $this->parseHandler($handler);
        $this->path = trim($path, '/');
        $this->methods = $this->prepareMethods($methods);
        $this->gateNames = $this->prepareGates($gates);

        Application::getInstance()->router->getRoutes()->add($this);
    }

    /**
     * @param string $path
     * @param string $handler
     * @param array|string[] $methods
     * @param array $gates
     * @return static
     */
    public static function create(
        string $path = self::DEFAULT_PATH,
        string $handler = self::DEFAULT_CONTROLLER,
        array $methods = self::DEFAULT_METHODS,
        array $gates = []
    )
    {
        return new static($path, $handler, $methods, $gates);
    }

    /**
     * @param string $path
     * @param string $handler
     * @param array $gates
     * @return static
     */
    public static function get(
        string $path = self::DEFAULT_PATH,
        string $handler = self::DEFAULT_CONTROLLER,
        array $gates = []
    )
    {
        return new static($path, $handler, ['GET'], $gates);
    }

    /**
     * @param string $path
     * @param string $handler
     * @param array $gates
     * @return static
     */
    public static function post(
        string $path = self::DEFAULT_PATH,
        string $handler = self::DEFAULT_CONTROLLER,
        array $gates = []
    )
    {
        return new static($path, $handler, ['POST'], $gates);
    }

    /**
     * @param string $path
     * @param string $handler
     * @param array $gates
     * @return static
     */
    public static function put(
        string $path = self::DEFAULT_PATH,
        string $handler = self::DEFAULT_CONTROLLER,
        array $gates = []
    )
    {
        return new static($path, $handler, ['PUT'], $gates);
    }

    /**
     * @param string $path
     * @param string $handler
     * @param array $gates
     * @return static
     */
    public static function delete(
        string $path = self::DEFAULT_PATH,
        string $handler = self::DEFAULT_CONTROLLER,
        array $gates = []
    )
    {
        return new static($path, $handler, ['DELETE'], $gates);
    }

    /**
     * @param string $path
     * @param string $handler
     * @param array $gates
     * @return static
     */
    public static function head(
        string $path = self::DEFAULT_PATH,
        string $handler = self::DEFAULT_CONTROLLER,
        array $gates = []
    )
    {
        return new static($path, $handler, ['HEAD'], $gates);
    }

    /**
     * @param string $handler
     * @return $this
     */
    public function parseHandler(string $handler)
    {
        $handlerParts = explode(self::CONTROLLER_SEPARATOR, $handler);
        $controller = $handlerParts[0];
        $action = $handlerParts[1];

        $this->controllerName = self::CONTROLLERS_NAMESPACE . $controller;
        $this->actionName = $action;

        return $this;
    }

    /**
     * @param array $methods
     * @return array
     */
    public function prepareMethods(array $methods)
    {
        return array_map(function ($method) {
            return strtoupper($method);
        }, $methods);
    }

    /**
     * @param array $gates
     * @return array
     */
    public function prepareGates(array $gates)
    {
        return array_map(function ($gate) {
            return self::GATES_NAMESPACE . ucfirst($gate . 'Gate');
        }, $gates);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function checkByRequest(Request $request)
    {
        return $this->path === $request->getPath() && in_array($request->getMethod(), $this->methods);
    }

    /**
     * @param string $path
     * @param string $method
     * @return bool
     */
    public function checkByPathAndMethod(string $path, string $method)
    {
        return $this->path === $path && in_array($method, $this->methods);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @param string $controllerName
     * @return $this
     */
    public function setControllerName(string $controllerName)
    {
        $this->controllerName = $controllerName;

        return $this;
    }

    /**
     * @return string
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @param string $actionName
     * @return $this
     */
    public function setActionName(string $actionName)
    {
        $this->actionName = $actionName;

        return $this;
    }

    /**
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param $methods
     * @return $this
     */
    public function setMethods($methods)
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @return array
     */
    public function getGateNames()
    {
        return $this->gateNames;
    }

    /**
     * @param array $gateNames
     * @return $this
     */
    public function setGateNames(array $gateNames)
    {
        $this->gateNames = $gateNames;

        return $this;
    }
}
