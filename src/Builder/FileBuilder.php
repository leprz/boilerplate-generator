<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2021. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\Builder;

use Leprz\Boilerplate\Exception\FileAlreadyExistsException;
use Leprz\Boilerplate\PathNode\File;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @package App\Tests\Shared\Infrastructure\Generator\Utils\Builder
 */
class FileBuilder
{
    /**
     * @var string
     */
    private string $src;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private Filesystem $filesystem;

    /**
     * @param string $src
     * @param \Symfony\Component\Filesystem\Filesystem $filesystem
     */
    public function __construct(string $src, Filesystem $filesystem)
    {
        //TODO src must have trailing slash at the end
        $this->src = $src;
        $this->filesystem = $filesystem;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\File $file
     * @return string
     */
    public function buildFilePath(File $file): string
    {
        $chain = $file->generateChain();

        return $this->src . implode(DIRECTORY_SEPARATOR, $chain) . '.' . $file->getExtension();
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\File $file
     * @param string $content
     * @param bool $override
     * @return string
     * @throws \Leprz\Boilerplate\Exception\FileAlreadyExistsException
     */
    public function createFile(File $file, string $content, bool $override = false): string
    {
        $filePath = $this->buildFilePath($file);

        if ($this->filesystem->exists($filePath) && $override === false) {
            throw FileAlreadyExistsException::inPath($filePath);
        }

        $this->filesystem->dumpFile($filePath, $content);

        return $filePath;
    }
}
