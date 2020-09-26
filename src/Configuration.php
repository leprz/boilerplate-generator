<?php

declare(strict_types=1);

namespace Leprz\Generator;

use Leprz\Generator\Builder\ClassMetadataBuilder;
use Leprz\Generator\Builder\ContentBuilderInterface;
use Leprz\Generator\Builder\FileContent\NetteClassContentBuilder;
use Leprz\Generator\Builder\PhpFileContentBuilder;
use Leprz\Generator\PathNodeType\PhpClass;
use Leprz\Generator\PathNodeType\PhpFile;
use Leprz\Generator\PathNodeType\PhpInterface;

/**
 * @package Leprz\Generator\PathNodeType\ValueObject
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
     * @var array<string, \Leprz\Generator\Builder\ContentBuilderInterface>
     */
    private array $contentBuilders;

    /**
     * @param string $appPrefix
     * @param string $appSrc
     */
    public function __construct(string $appPrefix, string $appSrc)
    {
        $this->appPrefix = $appPrefix;
        $this->appSrc = $appSrc;

        $phpFileContentBuilder = new PhpFileContentBuilder(
            new ClassMetadataBuilder($appPrefix),
            new NetteClassContentBuilder()
        );

        $this->contentBuilders = [
            PhpFile::class => $phpFileContentBuilder,
            PhpClass::class => $phpFileContentBuilder,
            PhpInterface::class => $phpFileContentBuilder
        ];
    }

    public function setContentBuilder(string $pathNodeTypeClass, ContentBuilderInterface $builder): void
    {
        $this->contentBuilders[$pathNodeTypeClass] = $builder;
    }

    /**
     * @return array<string, ContentBuilderInterface>
     */
    public function getContentBuilders(): array
    {
        return $this->contentBuilders;
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
}
