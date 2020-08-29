<?php

namespace PHPSoda;

use PHPSoda\Routing\Router;

/**
 * Class Application
 * @package PHPSoda
 */
class Application
{
    /**
     * @var static
     */
    private static $instance;

    /**
     * @var Router
     */
    public $router;

    /**
     * Application constructor.
     */
    private function __construct()
    {
        $this->router = new Router();
    }

    /**
     * @return static|null
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}
