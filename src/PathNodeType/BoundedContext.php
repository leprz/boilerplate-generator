<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNodeType;

/**
 * @package Leprz\Boilerplate\PathNodeType
 */
class BoundedContext extends PathNode
{
    /**
     * @param \Leprz\Boilerplate\PathNodeType\Layer $layer
     * @return \Leprz\Boilerplate\PathNodeType\Layer
     * @codeCoverageIgnore
     */
    public function addLayer(Layer $layer): Layer
    {
        $layer->setParent($this);

        return $layer;
    }

    /**
     * @param \Leprz\Boilerplate\PathNodeType\PathNode $parent
     * @codeCoverageIgnore
     */
    protected function setParent(PathNode $parent): void
    {
        $this->parent = null;
    }
}
