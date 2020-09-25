<?php

declare(strict_types=1);

namespace Leprz\Generator\PathNodeType;

/**
 * @package Leprz\Generator\PathNodeType
 */
class BoundedContext extends PathNode
{
    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param \Leprz\Generator\PathNodeType\Layer $layer
     * @return \Leprz\Generator\PathNodeType\Layer
     */
    public function addLayer(Layer $layer): Layer
    {
        $layer->setParent($this);

        return $layer;
    }

    /**
     * @param \Leprz\Generator\PathNodeType\PathNode $parent
     */
    protected function setParent(PathNode $parent): void
    {
        $this->parent = null;
    }
}
