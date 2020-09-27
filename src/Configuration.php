<?php

declare(strict_types=1);

namespace Leprz\Boilerplate;

use Leprz\Boilerplate\Builder\PhpFileContentBuilder;
use Leprz\Boilerplate\Builder\PhpClassMetadataBuilder;
use Leprz\Boilerplate\Builder\FileBuilder;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @package Leprz\Boilerplate
 */
class Configuration
{
    /**
     * @var string
     */
    private string $appPrefix;

    /**
     * @var string
     */
    private string $appSrc;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private Filesystem $filesystem;

    /**
     * @var \Leprz\Boilerplate\Builder\FileBuilder
     */
    private FileBuilder $fileBuilder;

    /**
     * @var \Leprz\Boilerplate\Builder\PhpClassMetadataBuilder
     */
    private PhpClassMetadataBuilder $phpClassMetadataBuilder;

    /**
     * @var \Leprz\Boilerplate\Builder\PhpFileContentBuilder
     */
    private PhpFileContentBuilder $phpFileContentBuilder;

    /**
     * @param string $appPrefix
     * @param string $appSrc
     */
    public function __construct(string $appPrefix, string $appSrc)
    {
        $this->appPrefix = trim($appPrefix, '\\');
        $this->appSrc = $appSrc;

        $this->filesystem = new Filesystem();
        $this->fileBuilder = new FileBuilder($this->appSrc, $this->filesystem);
        $this->phpClassMetadataBuilder = new PhpClassMetadataBuilder($this->appPrefix);
        $this->phpFileContentBuilder =  new PhpFileContentBuilder($this->phpClassMetadataBuilder);
    }

    /**
     * @return string
     */
    public function getAppPrefix(): string
    {
        return $this->appPrefix;
    }

    /**
     * @return string
     */
    public function getAppSrc(): string
    {
        return $this->appSrc;
    }

    public function getFileBuilder(): FileBuilder
    {
        return $this->fileBuilder;
    }

    public function getPhpClassMetadataBuilder(): PhpClassMetadataBuilder
    {
        return $this->phpClassMetadataBuilder;
    }

    public function getPhpFileContentBuilder(): PhpFileContentBuilder
    {
        return $this->phpFileContentBuilder;
    }
}
