<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2021. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNode\Php\Call;

class PhpArgument
{
    /**
     * @var mixed
     */
    private $value;
/**
     * @var bool
     */
    private bool $literalValue = false;
/**
     * @var string|null
     */
    private ?string $name;
/**
     * @param mixed $value
     * @param string|null $name
     */
    public function __construct($value, ?string $name = null)
    {
        $this->value = $value;
        $this->name = $name;
    }

    /**
     * @param string $class
     * @param string $const
     * @param string|null $attributeName
     * @return self
     */
    public static function const(string $class, string $const, ?string $attributeName = null): self
    {
        $self = new self($class . '::' . $const, $attributeName);
        $self->setLiteralValue(true);
        return $self;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isLiteralValue(): bool
    {
        return $this->literalValue;
    }

    /**
     * @param bool $literalValue
     */
    private function setLiteralValue(bool $literalValue): void
    {
        $this->literalValue = $literalValue;
    }
}
