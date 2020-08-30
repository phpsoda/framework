<?php

namespace PHPSoda\Patterns;

class SingletonRegistry implements RegistryInterface
{
    /**
     * @var Singleton[]
     */
    protected $instances;

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
     * @return Singleton|null
     */
    public function get(string $key, $default = null)
    {
        if ($this->has($key)) {
            return $this->instances[$key];
        } elseif (gettype($default) === 'object' && get_class($default) === 'Closure') {
            return $default();
        }

        return $default;
    }

    /**
     * @param string $key
     * @param Singleton $value
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
