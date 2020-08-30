<?php

namespace PHPSoda\Patterns;

/**
 * Interface RegistryInterface
 * @package PHPSoda\Patterns
 */
interface RegistryInterface
{
    /**
     * @param string $key
     * @return mixed
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
     * @return static
     */
    public function set(string $key, $value);

    /**
     * @param string $key
     * @return static
     */
    public function remove(string $key);
}