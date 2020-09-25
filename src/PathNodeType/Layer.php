<?php

declare(strict_types=1);

namespace Leprz\Generator\PathNodeType;

use InvalidArgumentException;

/**
 * @package Leprz\Generator\PathNodeType
 */
class Layer extends PathNode
{
    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        if (!in_array($name, ['Infrastructure', 'Application', 'Domain'])) {
            throw new InvalidArgumentException(sprintf('Not recognized layer: %s', $name));
        }

        $this->name = $name;
    }

    /**
     * @param \Leprz\Generator\PathNodeType\Folder $folder
     * @return \Leprz\Generator\PathNodeType\Folder
     */
    public function addFolder(Folder $folder): Folder
    {
        $folder->setParent($this);

        return $folder;
    }

    /**
     * @param \Leprz\Generator\PathNodeType\File $class
     * @return \Leprz\Generator\PathNodeType\File
     */
    public function addClass(File $class): File
    {
        $class->setParent($this);

        return $class;
    }
}
