<?php

namespace PHPSoda;

use Closure;
use PHPSoda\Dependency\AutoBuilder;
use PHPSoda\Http\Request;
use PHPSoda\Parsing\ArrayParser;
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
        $this->setPaths();
        
        $this->set(self::class, $this);
        $this->set(Router::class, new Router());
    }

    public function setPaths()
    {
        $this->set('path.base', $this->getBasePath());
        $this->set('path.config', $this->getConfigPath());
    }

    /**
     * @param string $basePath
     */
    public static function initialize(string $basePath = '')
    {
        self::$instance = new static($basePath);
        self::$initialized = true;
    }

    /**
     * @return Application
     */
    public static function getInstance(): Application
    {
        if (!self::$initialized) {
            self::initialize();
        }

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
        $router = $this->get(Router::class);
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
        $this->set('config.' . $name, ArrayParser::parse($this->getConfigFilePath($name . '.php')));
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
