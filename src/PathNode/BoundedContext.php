<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNode;

/**
 * @package Leprz\Boilerplate\PathNode
 */
class BoundedContext extends PathNode
{
    /**
     * @param \Leprz\Boilerplate\PathNode\Layer $layer
     * @return \Leprz\Boilerplate\PathNode\Layer
     * @codeCoverageIgnore
     */
    public function addLayer(Layer $layer): Layer
    {
        $layer->setParent($this);

        return $layer;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\PathNode $parent
     * @codeCoverageIgnore
     */
    protected function setParent(PathNode $parent): void
    {
        $this->parent = null;
    }
}
