<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNodeType;

/**
 * @package Leprz\Boilerplate\PathNodeType
 */
class Folder extends PathNode
{
    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
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
     * @param \Leprz\Boilerplate\PathNodeType\File $file
     * @return \Leprz\Boilerplate\PathNodeType\File
     */
    public function addFile(File $file): File
    {
        $file->setParent($this);

        return $file;
    }

    /**
     * @param \Leprz\Boilerplate\PathNodeType\PhpFile $file
     * @return \Leprz\Boilerplate\PathNodeType\PhpFile
     */
    public function addPhpFile(PhpFile $file): PhpFile
    {
        $file->setParent($this);

        return $file;
    }

    /**
     * @param \Leprz\Boilerplate\PathNodeType\PhpClass $class
     * @return \Leprz\Boilerplate\PathNodeType\PhpClass
     */
    public function addPhpClass(PhpClass $class): PhpClass
    {
        $class->setParent($this);

        return $class;
    }

    public function addPhpInterface(PhpInterface $interface): PhpInterface
    {
        $interface->setParent($this);

        return $interface;
    }
}
