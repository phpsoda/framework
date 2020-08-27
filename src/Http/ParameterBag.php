<?php

namespace PHPSoda\Http;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use PHPSoda\Helpers\ArrayHelper;
use Traversable;

/**
 * Class ParameterBag
 * @package PHPSoda\Http
 */
class ParameterBag implements IteratorAggregate, Countable, JsonSerializable
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     * ParameterBag constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return ArrayHelper::hasKey($key, $this->parameters);
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return $this->has($key) ? $this->parameters[$key] : $default;
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function set(string $key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * @return ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->parameters);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->parameters);
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->parameters;
    }
}