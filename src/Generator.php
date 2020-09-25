<?php

declare(strict_types=1);

namespace Leprz\Generator;

use Leprz\Generator\Builder\ClassContentBuilder;
use Leprz\Generator\Builder\FileBuilder;
use Leprz\Generator\Builder\ClassMetadataBuilder;
use Leprz\Generator\PathNodeType\File;
use Leprz\Generator\PathNodeType\Method;
use Leprz\Generator\PathNodeType\PhpClass;
use Leprz\Generator\PathNodeType\PhpFile;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @package Leprz\Generator
 */
class Generator
{
    /**
     * @var \Leprz\Generator\Builder\FileBuilder
     */
    private FileBuilder $fileBuilder;

    /**
     * @var \Leprz\Generator\Builder\ClassMetadataBuilder
     */
    private ClassMetadataBuilder $namespaceBuilder;

    /**
     * @var \Leprz\Generator\Builder\ClassContentBuilder
     */
    private ClassContentBuilder $classContentBuilder;

    /**
     * @param \Symfony\Component\Filesystem\Filesystem $filesystem
     * @param \Leprz\Generator\Configuration $configuration
     */
    public function __construct(Filesystem $filesystem, Configuration $configuration)
    {
        $this->fileBuilder = new FileBuilder($configuration->getAppSrc(), $filesystem);
        $this->namespaceBuilder = new ClassMetadataBuilder($configuration->getAppPrefix());
        $this->classContentBuilder = new ClassContentBuilder($this->namespaceBuilder);
    }

    /**
     * @param \Leprz\Generator\PathNodeType\File $file
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
     * @param \Leprz\Generator\PathNodeType\PhpClass $file
     * @param \Leprz\Generator\PathNodeType\Method $method
     * @return string
     * @throws \Leprz\Generator\Exception\ClassContentMalformedException
     */
    public function appendMethod(PhpClass $file, Method $method): string
    {
        return $this->fileBuilder->appendToFile($file, $this->classContentBuilder->buildMethod($method));
    }
}
