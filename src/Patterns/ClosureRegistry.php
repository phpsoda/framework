<?php

namespace PHPSoda\Patterns;

use Closure;

/**
 * Class ClosureRegistry
 * @package PHPSoda\Patterns
 */
class ClosureRegistry implements RegistryInterface
{
    /**
     * @var Closure[]
     */
    protected $instances;

    public function __construct()
    {
        $this->instances = [];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return array_key_exists($key, $this->instances);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return Closure|null
     */
    public function get(string $key, $default = null)
    {
        if ($this->has($key)) {
            return $this->instances[$key]();
        } elseif (gettype($default) === 'object' && get_class($default) === 'Closure') {
            return $default();
        }

        return $default;
    }

    /**
     * @param string $key
     * @param Closure $value
     * @return $this
     */
    public function set(string $key, $value)
    {
        $this->instances[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function remove(string $key)
    {
        if ($this->has($key)) {
            unset($this->instances[$key]);
        }

        return $this;
    }
}
