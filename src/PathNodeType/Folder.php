<?php

declare(strict_types=1);

namespace Leprz\Generator\PathNodeType;

/**
 * @package Leprz\Generator\PathNodeType
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
     * @param \Leprz\Generator\PathNodeType\Folder $folder
     * @return \Leprz\Generator\PathNodeType\Folder
     */
    public function addFolder(Folder $folder): Folder
    {
        $folder->setParent($this);

        return $folder;
    }

    /**
     * @param \Leprz\Generator\PathNodeType\File $file
     * @return \Leprz\Generator\PathNodeType\File
     */
    public function addFile(File $file): File
    {
        $file->setParent($this);

        return $file;
    }

    /**
     * @param \Leprz\Generator\PathNodeType\PhpFile $file
     * @return \Leprz\Generator\PathNodeType\PhpFile
     */
    public function addPhpFile(PhpFile $file): PhpFile
    {
        $file->setParent($this);

        return $file;
    }

    /**
     * @param \Leprz\Generator\PathNodeType\PhpClass $class
     * @return \Leprz\Generator\PathNodeType\PhpClass
     */
    public function addPhpClass(PhpClass $class): PhpClass
    {
        $class->setParent($this);

        return $class;
    }
}
