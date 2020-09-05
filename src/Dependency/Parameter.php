<?php

namespace PHPSoda\Dependency;

/**
 * Class Parameter
 * @package PHPSoda\Dependency
 */
class Parameter
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var ParameterType|null
     */
    private $type;
    /**
     * @var bool
     */
    private $optional;

    public function __construct(string $name, ?ParameterType $type, bool $optional = false)
    {
        $this->name = $name;
        $this->type = $type;
        $this->optional = $optional;
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
     * @return Parameter
     */
    public function setName(string $name): Parameter
    {
        $this->name = $name;

        return $this;
    }

    public function hasType(): bool
    {
        return $this->type !== null;
    }

    /**
     * @return ParameterType|null
     */
    public function getType(): ?ParameterType
    {
        return $this->type;
    }

    /**
     * @param ParameterType|null $type
     * @return $this
     */
    public function setType(?ParameterType $type): Parameter
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOptional(): bool
    {
        return $this->optional;
    }

    /**
     * @param bool $optional
     * @return Parameter
     */
    public function setOptional(bool $optional): Parameter
    {
        $this->optional = $optional;

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
