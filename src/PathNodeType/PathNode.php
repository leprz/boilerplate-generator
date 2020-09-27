<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNodeType;

/**
 * @package Leprz\Boilerplate\PathNodeType
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
     * @var \Leprz\Boilerplate\PathNodeType\PathNode|null
     */
    protected ?PathNode $parent = null;

    protected function setParent(PathNode $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return \Leprz\Boilerplate\PathNodeType\PathNode[]
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
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
