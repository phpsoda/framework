<?php

namespace PHPSoda\Container;

use Countable;
use IteratorAggregate;

/**
 * Interface ContainerInterface
 * @package PHPSoda\Container
 */
interface ContainerInterface extends IteratorAggregate, Countable
{
    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key);

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set(string $key, $value);

    /**
     * @param string $key
     * @return $this
     */
    public function clear(string $key);
}
