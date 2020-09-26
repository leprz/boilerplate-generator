<?php

declare(strict_types=1);

namespace Leprz\Boilerplate;

use Leprz\Boilerplate\Builder\ClassContentBuilder;
use Leprz\Boilerplate\Builder\FileBuilder;
use Leprz\Boilerplate\Builder\ClassMetadataBuilder;
use Leprz\Boilerplate\PathNodeType\File;
use Leprz\Boilerplate\PathNodeType\Method;
use Leprz\Boilerplate\PathNodeType\PhpClass;
use Leprz\Boilerplate\PathNodeType\PhpFile;
use Symfony\Component\Filesystem\Filesystem;

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
     * @var \Leprz\Boilerplate\Builder\ClassMetadataBuilder
     */
    private ClassMetadataBuilder $namespaceBuilder;

    /**
     * @var \Leprz\Boilerplate\Builder\ClassContentBuilder
     */
    private ClassContentBuilder $classContentBuilder;

    /**
     * @param \Symfony\Component\Filesystem\Filesystem $filesystem
     * @param \Leprz\Boilerplate\Configuration $configuration
     */
    public function __construct(Filesystem $filesystem, Configuration $configuration)
    {
        $this->fileBuilder = new FileBuilder($configuration->getAppSrc(), $filesystem);
        $this->namespaceBuilder = new ClassMetadataBuilder($configuration->getAppPrefix());
        $this->classContentBuilder = new ClassContentBuilder($this->namespaceBuilder);
    }

    /**
     * @param \Leprz\Boilerplate\PathNodeType\File $file
     * @return string file path
     */
    public function generate(File $file): string
    {
        if ($file instanceof PhpFile) {
            return $this->fileBuilder->createFile($file, $this->classContentBuilder->build($file));
        }

        return $this->fileBuilder->createFile($file, '');
    }

    /**
     * @param \Leprz\Boilerplate\PathNodeType\PhpClass $file
     * @param \Leprz\Boilerplate\PathNodeType\Method $method
     * @return string
     * @throws \Leprz\Boilerplate\Exception\ClassContentMalformedException
     */
    public function appendMethod(PhpClass $file, Method $method): string
    {
        return $this->fileBuilder->appendToFile($file, $this->classContentBuilder->buildMethod($method));
    }
}
