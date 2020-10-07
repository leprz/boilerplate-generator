<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2020. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNode\Php;

/**
 * @package Leprz\Boilerplate\PathNode\Php
 */
class PhpType
{
    /**
     * @var string
     */
    private string $primitiveType;

    /**
     * @var \Leprz\Boilerplate\PathNode\Php\PhpClass|null
     */
    private ?PhpClass $objectType = null;

    /**
     * @param string $primitive
     * @codeCoverageIgnore
     */
    private function __construct(string $primitive)
    {
        $this->primitiveType = $primitive;
    }

    /**
     * @return self
     * @codeCoverageIgnore
     */
    public static function string(): self
    {
        return new self('string');
    }

    /**
     * @return self
     * @codeCoverageIgnore
     */
    public static function void(): self
    {
        return new self('void');
    }

    /**
     * @return self
     * @codeCoverageIgnore
     */
    public static function boolean(): self
    {
        return new self('bool');
    }

    /**
     * @return self
     * @codeCoverageIgnore
     */
    public static function int(): self
    {
        return new self('int');
    }

    /**
     * @return self
     * @codeCoverageIgnore
     */
    public static function float(): self
    {
        return new self('float');
    }

    /**
     * @return self
     * @codeCoverageIgnore
     */
    public static function callable(): self
    {
        return new self('callable');
    }

    /**
     * @return self
     * @codeCoverageIgnore
     */
    public static function iterable(): self
    {
        return new self('iterable');
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpClass|null $ofType
     * @return self
     * @codeCoverageIgnore
     */
    public static function object(?PhpClass $ofType = null): self
    {
        $self = new self('object');

        $self->objectType = $ofType;

        return $self;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpClass|null $ofType
     * @return self
     * @codeCoverageIgnore
     */
    public static function array(?PhpClass $ofType = null): self
    {
        $self = new self('array');

        $self->objectType = $ofType;

        return $self;
    }

    /**
     * @return bool
     */
    public function isPrimitive(): bool
    {
        return $this->objectType === null;
    }

    /**
     * @return \Leprz\Boilerplate\PathNode\Php\PhpClass|null
     * @codeCoverageIgnore
     */
    public function ofType(): ?PhpClass
    {
        return $this->objectType;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpType $type
     * @return bool
     */
    public function typeEquals(self $type): bool
    {
        return $this->primitiveType === $type->primitiveType;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function __toString(): string
    {
        return $this->primitiveType;
    }
}
