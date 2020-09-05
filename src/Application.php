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
     * @var Application
     */
    private static $instance;

    /**
     * @var string
     */
    private $basePath;

    /**
     * Application constructor.
     * @param string|null $basePath
     */
    public function __construct(string $basePath = null)
    {
        parent::__construct();

        if ($basePath) {
            $this->setBasePath($basePath);
        }

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
        $this->basePath = rtrim($basePath, '\/');

        return $this;
    }
}
