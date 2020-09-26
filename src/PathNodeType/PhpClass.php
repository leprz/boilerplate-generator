<?php

declare(strict_types=1);

namespace Leprz\Generator\PathNodeType;

/**
 * @package Leprz\Generator\PathNodeType
 */
class PhpClass extends PhpFile
{
    /**
     * @var \Leprz\Generator\PathNodeType\PhpClass|null
     */
    private ?PhpClass $extends = null;

    /**
     * @var \Leprz\Generator\PathNodeType\PhpInterface[]
     */
    private array $implements = [];

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->name;
    }

    public function extends(self $phpClass): self
    {
        $this->extends = $phpClass;

        return $this;
    }

    /**
     * @param \Leprz\Generator\PathNodeType\PhpInterface ...$phpInterface
     * @return $this
     */
    public function implements(PhpInterface ...$phpInterface): self
    {
        $this->implements = $phpInterface;

        return $this;
    }

    /**
     * @return \Leprz\Generator\PathNodeType\PhpClass|null
     */
    public function getExtends(): ?PhpClass
    {
        return $this->extends;
    }

    /**
     * @return \Leprz\Generator\PathNodeType\PhpInterface[]
     */
    public function getImplements(): array
    {
        return $this->implements;
    }
}
