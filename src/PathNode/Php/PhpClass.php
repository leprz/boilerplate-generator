<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNode\Php;

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
     * @return string
     * @codeCoverageIgnore
     */
    public function getClassName(): string
    {
        return $this->name;
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
}
