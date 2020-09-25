<?php

declare(strict_types=1);

namespace Leprz\Generator\PathNodeType;

/**
 * @package Leprz\Generator\PathNodeType
 */
abstract class PathNode
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var \Leprz\Generator\PathNodeType\PathNode|null
     */
    protected ?PathNode $parent = null;

    protected function setParent(PathNode $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return \Leprz\Generator\PathNodeType\PathNode[]
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
