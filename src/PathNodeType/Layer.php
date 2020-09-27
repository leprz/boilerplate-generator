<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNodeType;

use InvalidArgumentException;

/**
 * @package Leprz\Boilerplate\PathNodeType
 */
class Layer extends PathNode
{
    private const LAYER_INFRASTRUCTURE = 'Infrastructure';
    private const LAYER_APPLICATION = 'Application';
    private const LAYER_DOMAIN = 'Domain';

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        if (!in_array($name, [self::LAYER_INFRASTRUCTURE, self::LAYER_APPLICATION, self::LAYER_DOMAIN])) {
            throw new InvalidArgumentException(sprintf('Not recognized layer: %s', $name));
        }

        parent::__construct($name);
    }

    /**
     * @param \Leprz\Boilerplate\PathNodeType\Folder $folder
     * @return \Leprz\Boilerplate\PathNodeType\Folder
     * @codeCoverageIgnore
     */
    public function addFolder(Folder $folder): Folder
    {
        $folder->setParent($this);

        return $folder;
    }

    /**
     * @param \Leprz\Boilerplate\PathNodeType\File $class
     * @return \Leprz\Boilerplate\PathNodeType\File
     * @codeCoverageIgnore
     */
    public function addClass(File $class): File
    {
        $class->setParent($this);

        return $class;
    }
}
