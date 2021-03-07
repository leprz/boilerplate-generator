<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2021. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate;

use Leprz\Boilerplate\Builder\PhpFileContentBuilder;
use Leprz\Boilerplate\Builder\FileBuilder;
use Leprz\Boilerplate\PathNode\File;
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
     * @param bool $override
     * @return string file path
     * @throws \Leprz\Boilerplate\Exception\FileAlreadyExistsException
     */
    public function generate(File $file, bool $override = false): string
    {
        if ($file instanceof PhpFile) {
            return $this->fileBuilder->createFile($file, $this->phpFileContentBuilder->build($file), $override);
        }

        return $this->fileBuilder->createFile($file, '', $override);
    }
}
