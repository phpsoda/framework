<?php

namespace PHPSoda\Dependency;

/**
 * Class ParameterType
 * @package PHPSoda\Dependency
 */
class ParameterType
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var bool
     */
    private $builtin;

    /**
     * ParameterType constructor.
     * @param string $name
     * @param bool $builtin
     */
    public function __construct(string $name, bool $builtin)
    {
        $this->name = $name;
        $this->builtin = $builtin;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ParameterType
     */
    public function setName(string $name): ParameterType
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBuiltin(): bool
    {
        return $this->builtin;
    }

    /**
     * @param bool $builtin
     * @return ParameterType
     */
    public function setBuiltin(bool $builtin): ParameterType
    {
        $this->builtin = $builtin;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
