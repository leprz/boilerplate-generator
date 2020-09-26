<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNodeType;

use InvalidArgumentException;

/**
 * @package Leprz\Boilerplate\PathNodeType
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
     * @param \Leprz\Boilerplate\PathNodeType\Folder $folder
     * @return \Leprz\Boilerplate\PathNodeType\Folder
     */
    public function addFolder(Folder $folder): Folder
    {
        $folder->setParent($this);

        return $folder;
    }

    /**
     * @param \Leprz\Boilerplate\PathNodeType\File $class
     * @return \Leprz\Boilerplate\PathNodeType\File
     */
    public function addClass(File $class): File
    {
        $class->setParent($this);

        return $class;
    }
}
