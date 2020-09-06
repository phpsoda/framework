<?php

namespace PHPSoda\Routing;

use Closure;
use PHPSoda\Application;
use PHPSoda\Helpers\ArrayHelper;
use PHPSoda\Helpers\StringHelper;

/**
 * Class Route
 *
 * @package PHPSoda\Routing
 */
class Route
{
    const ACTION_DELIMITER = '@';
    const ROUTE_PARAMETER_PATTERN = ':(\w+)';
    const ROUTE_ARGUMENT_PATTERN = '(\w+)';

    /**
     * @var string
     */
    protected $uri;
    /**
     * @var array
     */
    protected $methods;
    /**
     * @var Closure|string
     */
    protected $action;

    /**
     * Route constructor.
     *
     * @param string         $uri
     * @param array          $methods
     * @param Closure|string $action
     */
    public function __construct(string $uri, array $methods, $action)
    {
        $this->setUri($uri);
        $this->setMethods($methods);
        $this->setAction($action);
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return StringHelper::replace(self::ROUTE_PARAMETER_PATTERN, self::ROUTE_ARGUMENT_PATTERN, $this->uri);
    }

    public function getParams(): array
    {
        preg_match_all('#' . self::ROUTE_PARAMETER_PATTERN . '#', $this->uri, $routeParams);

        return $routeParams[1];
    }

    /**
     * @param string $path
     * @return array
     */
    public function getArgs(string $path): array
    {
        $parameters = $this->getParams();

        if (count($parameters) === 0) {
            return [];
        } else {
            preg_match_all('#' . $this->getPattern() . '#', $path, $routeArgs);

            return array_combine(
                $this->getParams(),
                ArrayHelper::flatten(array_splice($routeArgs, 1))
            );
        }
    }

    /**
     * @return array
     */
    public function parseAction()
    {
        $actionParts = explode(Route::ACTION_DELIMITER, $this->action);

        return [
            'controller' => Application::CONTROLLERS_NAMESPACE . $actionParts[0],
            'action' => $actionParts[1],
        ];
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return Route
     */
    public function setUri(string $uri): Route
    {
        $this->uri = trim($uri, '/');

        return $this;
    }

    /**
     * @return array
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param array $methods
     * @return Route
     */
    public function setMethods(array $methods): Route
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @return Closure|string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param Closure|string $action
     * @return Route
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }
}
