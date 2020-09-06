<?php

namespace PHPSoda\Container;

use ArrayIterator;
use Closure;

/**
 * Class Container
 *
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
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return Container
     */
    public function setItems(array $items): Container
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @inheritDoc
     */
    public function get(string $key, $default = null)
    {
        if ($this->has($key)) {
            if ($this->items[$key] instanceof Closure) {
                return $this->items[$key]();
            }

            return $this->items[$key];
        } elseif ($default instanceof Closure) {
            return $default();
        } else {
            return $default;
        }
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, $value): ContainerInterface
    {
        $this->items[$key] = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function clear(string $key): ContainerInterface
    {
        if ($this->has($key)) {
            unset($this->items[$key]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->items);
    }
}
