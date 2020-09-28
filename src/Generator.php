<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2020. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate;

use Leprz\Boilerplate\Builder\PhpFileContentBuilder;
use Leprz\Boilerplate\Builder\FileBuilder;
use Leprz\Boilerplate\PathNode\File;
use Leprz\Boilerplate\PathNode\Php\PhpMethod;
use Leprz\Boilerplate\PathNode\Php\PhpClass;
use Leprz\Boilerplate\PathNode\Php\PhpFile;

/**
 * @package Leprz\Boilerplate
 */
class Generator
{
    /**
     * @var \Leprz\Boilerplate\Builder\FileBuilder
     */
    private FileBuilder $fileBuilder;

    /**
     * @var \Leprz\Boilerplate\Builder\PhpFileContentBuilder
     */
    private PhpFileContentBuilder $phpFileContentBuilder;

    /**
     * @param \Leprz\Boilerplate\Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->fileBuilder = $configuration->getFileBuilder();
        $this->phpFileContentBuilder = $configuration->getPhpFileContentBuilder();
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\File $file
     * @return string file path
     */
    public function generate(File $file): string
    {
        if ($file instanceof PhpFile) {
            return $this->fileBuilder->createFile($file, $this->phpFileContentBuilder->build($file));
        }

        return $this->fileBuilder->createFile($file, '');
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpClass $file
     * @param \Leprz\Boilerplate\PathNode\Php\PhpMethod $method
     * @return string
     * @throws \Leprz\Boilerplate\Exception\ClassContentMalformedException
     */
    public function appendMethod(PhpClass $file, PhpMethod $method): string
    {
        return $this->fileBuilder->appendToFile($file, $this->phpFileContentBuilder->buildMethod($method));
    }
}
