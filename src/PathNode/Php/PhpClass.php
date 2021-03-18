<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2021. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNode\Php;

use Leprz\Boilerplate\PathNode\Folder;
use Leprz\Boilerplate\PathNode\Php\Call\PhpAttributeCall;

/**
 * @package Leprz\Boilerplate\PathNode\Php
 */
class PhpClass extends PhpFile
{
    /**
     * @var \Leprz\Boilerplate\PathNode\Php\PhpClass|null
     */
    private ?PhpClass $extends = null;

    /**
     * @var \Leprz\Boilerplate\PathNode\Php\PhpInterface[]
     */
    private array $implements = [];

    /**
     * @var \Leprz\Boilerplate\PathNode\Php\PhpTrait[]
     */
    private array $usedTraits = [];

    /**
     * @var bool
     */
    private bool $isExternal = false;

    /**
     * @var \Leprz\Boilerplate\PathNode\Php\Call\PhpAttributeCall[]
     */
    private array $attributes = [];

    /**
     * @param string $class
     * @return static
     */
    public static function fromFQCN(string $class): self
    {
        $explodedClassName = explode("\\", $class);

        $self = new static(array_pop($explodedClassName));
        $self->isExternal = true;

        $parent = $self;

        while ($folderName = array_pop($explodedClassName)) {
            $parent = $parent->parent = new Folder($folderName);
        }

        return $self;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getClassName(): string
    {
        return $this->name;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpMethod $method
     * @return \Leprz\Boilerplate\PathNode\Php\PhpClass
     * @codeCoverageIgnore
     */
    public function addMethod(PhpMethod $method): self
    {
        $this->methods[] = $method;

        return $this;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpClass $phpClass
     * @return $this
     * @codeCoverageIgnore
     */
    public function extends(self $phpClass): self
    {
        $this->extends = $phpClass;

        return $this;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpInterface ...$phpInterface
     * @return $this
     * @codeCoverageIgnore
     */
    public function implements(PhpInterface ...$phpInterface): self
    {
        $this->implements = $phpInterface;

        return $this;
    }

    /**
     * @return \Leprz\Boilerplate\PathNode\Php\PhpClass|null
     * @codeCoverageIgnore
     */
    public function getExtends(): ?PhpClass
    {
        return $this->extends;
    }

    /**
     * @return \Leprz\Boilerplate\PathNode\Php\PhpInterface[]
     * @codeCoverageIgnore
     */
    public function getImplements(): array
    {
        return $this->implements;
    }

    /**
     * @return bool
     */
    public function isExternal(): bool
    {
        return $this->isExternal;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpTrait ...$traits
     * @return $this
     */
    public function useTraits(PhpTrait ...$traits): self
    {
        $this->usedTraits = $traits;

        return $this;
    }

    /**
     * @return \Leprz\Boilerplate\PathNode\Php\PhpTrait[]
     */
    public function getUsedTraits(): array
    {
        return $this->usedTraits;
    }

    public function addAttribute(PhpAttributeCall $attribute): self
    {
        $this->attributes[] = $attribute;

        return $this;
    }

    /**
     * @return \Leprz\Boilerplate\PathNode\Php\Call\PhpAttributeCall[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
