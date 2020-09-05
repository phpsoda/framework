<?php

namespace PHPSoda;

use PHPSoda\Container\Container;
use PHPSoda\Routing\Router;

/**
 * Class Application
 * @package PHPSoda
 */
class Application extends Container
{
    /**
     * @var Router
     */
    public $router;

    /**
     * @var Application
     */
    private static $instance;

    /**
     * Application constructor.
     */
    private function __construct()
    {
        parent::__construct();

        $this->set('router', new Router());
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
}
