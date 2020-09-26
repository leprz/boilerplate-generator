<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNodeType;

/**
 * @package Leprz\Boilerplate\PathNodeType
 */
class PhpClass extends PhpFile
{
    /**
     * @var \Leprz\Boilerplate\PathNodeType\PhpClass|null
     */
    private ?PhpClass $extends = null;

    /**
     * @var \Leprz\Boilerplate\PathNodeType\PhpInterface[]
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
     * @param \Leprz\Boilerplate\PathNodeType\PhpInterface ...$phpInterface
     * @return $this
     */
    public function implements(PhpInterface ...$phpInterface): self
    {
        $this->implements = $phpInterface;

        return $this;
    }

    /**
     * @return \Leprz\Boilerplate\PathNodeType\PhpClass|null
     */
    public function getExtends(): ?PhpClass
    {
        return $this->extends;
    }

    /**
     * @return \Leprz\Boilerplate\PathNodeType\PhpInterface[]
     */
    public function getImplements(): array
    {
        return $this->implements;
    }
}
