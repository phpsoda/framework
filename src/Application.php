<?php

namespace PHPSoda;

use PHPSoda\Patterns\Singleton;
use PHPSoda\Patterns\SingletonRegistry;
use PHPSoda\Routing\Router;

/**
 * Class Application
 * @package PHPSoda
 */
class Application
{
    /**
     * @var Router
     */
    public $router;
    /**
     * @var SingletonRegistry
     */
    private $singletons;

    /**
     * @var Application
     */
    private static $instance;

    /**
     * Application constructor.
     */
    private function __construct()
    {
        $this->router = new Router();
        $this->singletons = new SingletonRegistry();
    }

    /**
     * @return Application
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Application();
        }

        return self::$instance;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|Singleton
     */
    public function make(string $key, $default = null)
    {
        return $this->singletons->get($key) ?? $default;
    }
}
