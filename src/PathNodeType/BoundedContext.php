<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNodeType;

/**
 * @package Leprz\Boilerplate\PathNodeType
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
     * @param \Leprz\Boilerplate\PathNodeType\Layer $layer
     * @return \Leprz\Boilerplate\PathNodeType\Layer
     */
    public function addLayer(Layer $layer): Layer
    {
        $layer->setParent($this);

        return $layer;
    }

    /**
     * @param \Leprz\Boilerplate\PathNodeType\PathNode $parent
     */
    protected function setParent(PathNode $parent): void
    {
        $this->parent = null;
    }
}
