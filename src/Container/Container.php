<?php

namespace PHPSoda\Container;

use ArrayIterator;
use Closure;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Class Container
 * @package PHPSoda\Container
 */
class Container implements ContainerInterface
{
    /**
     * @var array
     */
    protected $items;

    /**
     * Container constructor.
     */
    public function __construct()
    {
        $this->items = [];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null) {
        if (!$this->has($key)) {
            return $default;
        }

        $value = $this->items[$key];

        if ($value instanceof Closure) {
            return $value();
        }

        if ($default instanceof Closure) {
            return $default();
        }

        return $value ?? $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set(string $key, $value) {
        $this->items[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function clear(string $key)
    {
        if ($this->has($key)) {
            unset($this->items[$key]);
        }

        return $this;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->has($offset)) {
            unset($this->items[$offset]);
        }
    }

    /**
     * @return ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }
}
