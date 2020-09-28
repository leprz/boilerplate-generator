<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNode;

/**
 * @package Leprz\Boilerplate\PathNode
 */
abstract class PathNode
{
    /**
     * @var string
     */
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }


    /**
     * @var \Leprz\Boilerplate\PathNode\PathNode|null
     */
    protected ?PathNode $parent = null;

    protected function setParent(PathNode $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return \Leprz\Boilerplate\PathNode\PathNode[]
     */
    protected function generateChain(): array
    {
        if ($this->parent !== null) {
            return [...$this->parent->generateChain(), $this];
        }

        return [$this];
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
