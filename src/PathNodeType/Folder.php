<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNodeType;

/**
 * @package Leprz\Boilerplate\PathNodeType
 */
class Folder extends PathNode
{
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
     * @param \Leprz\Boilerplate\PathNodeType\File $file
     * @return \Leprz\Boilerplate\PathNodeType\File
     * @codeCoverageIgnore
     */
    public function addFile(File $file): File
    {
        $file->setParent($this);

        return $file;
    }

    /**
     * @param \Leprz\Boilerplate\PathNodeType\PhpFile $file
     * @return \Leprz\Boilerplate\PathNodeType\PhpFile
     * @codeCoverageIgnore
     */
    public function addPhpFile(PhpFile $file): PhpFile
    {
        $file->setParent($this);

        return $file;
    }

    /**
     * @param \Leprz\Boilerplate\PathNodeType\PhpClass $class
     * @return \Leprz\Boilerplate\PathNodeType\PhpClass
     * @codeCoverageIgnore
     */
    public function addPhpClass(PhpClass $class): PhpClass
    {
        $class->setParent($this);

        return $class;
    }

    /**
     * @param \Leprz\Boilerplate\PathNodeType\PhpInterface $interface
     * @return \Leprz\Boilerplate\PathNodeType\PhpInterface
     * @codeCoverageIgnore
     */
    public function addPhpInterface(PhpInterface $interface): PhpInterface
    {
        $interface->setParent($this);

        return $interface;
    }
}
