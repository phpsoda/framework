<?php

namespace PHPSoda\Container;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;

/**
 * Interface ContainerInterface
 *
 * @package PHPSoda\Container
 */
interface ContainerInterface extends JsonSerializable, IteratorAggregate, Countable
{
    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * @param string $key
     * @param mixed  $value
     * @return $this
     */
    public function set(string $key, $value): ContainerInterface;

    /**
     * @param string $key
     * @return $this
     */
    public function clear(string $key): ContainerInterface;
}
