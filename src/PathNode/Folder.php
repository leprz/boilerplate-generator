<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2020. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNode;

use Leprz\Boilerplate\PathNode\Php\PhpClass;
use Leprz\Boilerplate\PathNode\Php\PhpFile;
use Leprz\Boilerplate\PathNode\Php\PhpInterface;

/**
 * @package Leprz\Boilerplate\PathNode
 */
class Folder extends PathNode
{
    /**
     * @param \Leprz\Boilerplate\PathNode\Folder $folder
     * @return \Leprz\Boilerplate\PathNode\Folder
     * @codeCoverageIgnore
     */
    public function addFolder(Folder $folder): Folder
    {
        $folder->setParent($this);

        return $folder;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\File $file
     * @return \Leprz\Boilerplate\PathNode\File
     * @codeCoverageIgnore
     */
    public function addFile(File $file): File
    {
        $file->setParent($this);

        return $file;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpFile $file
     * @return \Leprz\Boilerplate\PathNode\Php\PhpFile
     * @codeCoverageIgnore
     */
    public function addPhpFile(PhpFile $file): PhpFile
    {
        $file->setParent($this);

        return $file;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpClass $class
     * @return \Leprz\Boilerplate\PathNode\Php\PhpClass
     * @codeCoverageIgnore
     */
    public function addPhpClass(PhpClass $class): PhpClass
    {
        $class->setParent($this);

        return $class;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpInterface $interface
     * @return \Leprz\Boilerplate\PathNode\Php\PhpInterface
     * @codeCoverageIgnore
     */
    public function addPhpInterface(PhpInterface $interface): PhpInterface
    {
        $interface->setParent($this);

        return $interface;
    }
}
