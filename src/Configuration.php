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
     * @codeCoverageIgnore
     */
    public function getAppPrefix(): string
    {
        return $this->appPrefix;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getAppSrc(): string
    {
        return $this->appSrc;
    }

    /**
     * @return \Leprz\Boilerplate\Builder\FileBuilder
     * @codeCoverageIgnore
     */
    public function getFileBuilder(): FileBuilder
    {
        return $this->fileBuilder;
    }

    /**
     * @return \Leprz\Boilerplate\Builder\PhpClassMetadataBuilder
     * @codeCoverageIgnore
     */
    public function getPhpClassMetadataBuilder(): PhpClassMetadataBuilder
    {
        return $this->phpClassMetadataBuilder;
    }

    /**
     * @return \Leprz\Boilerplate\Builder\PhpFileContentBuilder
     * @codeCoverageIgnore
     */
    public function getPhpFileContentBuilder(): PhpFileContentBuilder
    {
        return $this->phpFileContentBuilder;
    }
}
