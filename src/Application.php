<?php

namespace PHPSoda;

use Closure;
use PHPSoda\Config\ArrayConfig;
use PHPSoda\Dependency\AutoBuilder;
use PHPSoda\Http\Request;
use PHPSoda\Routing\Router;
use ReflectionException;

/**
 * Class Application
 *
 * @package PHPSoda
 */
class Application extends AutoBuilder
{
    const CONTROLLERS_NAMESPACE = 'App\\Controllers\\';

    /**
     * @var Application
     */
    private static $instance;
    /**
     * @var bool
     */
    private static $initialized = false;

    /**
     * @var string
     */
    private $basePath;

    /**
     * Application constructor.
     *
     * @param string $basePath
     */
    private function __construct(string $basePath = '')
    {
        parent::__construct();

        $this->setBasePath($basePath);
    }

    /**
     * @param string $basePath
     * @return Application
     */
    public static function initialize(string $basePath = ''): Application
    {
        self::$instance = new static($basePath);
        self::$initialized = true;

        return self::$instance;
    }

    /**
     * @return Application
     */
    public static function getInstance(): Application
    {
        return self::$instance;
    }

    /**
     * @return bool
     */
    public static function isInitialized(): bool
    {
        return self::$initialized;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws ReflectionException
     */
    public function handleRequest(Request $request)
    {
        /**
         * @var Router $router
         */
        $router = $this->get('router');
        $route = $router->match($request);
        $action = $route->getAction();

        $args = array_values($route->getArgs($request->getPath()));
        $args[] = $request;

        if ($action instanceof Closure) {
            return $action(...$args);
        } else {
            ['controller' => $controllerName, 'action' => $actionName] = $route->parseAction();
            $controller = $this->build($controllerName);

            return $controller->$actionName(...$args);
        }
    }

    /**
     * @param string $name
     */
    public function loadConfig(string $name)
    {
        $this->set('config.' . $name, ArrayConfig::parse($this->getConfigFilePath($name . '.php')));
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     * @return Application
     */
    public function setBasePath(string $basePath): Application
    {
        $this->basePath = rtrim($basePath, '/');

        return $this;
    }

    /**
     * @return string
     */
    public function getConfigPath(): string
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'config';
    }

    /**
     * @param string $file
     * @return string
     */
    public function getConfigFilePath(string $file): string
    {
        return $this->getConfigPath() . DIRECTORY_SEPARATOR . $file;
    }
}
