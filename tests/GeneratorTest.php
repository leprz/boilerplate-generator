<?php
/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2020. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\Tests;

use Leprz\Boilerplate\Builder\FileBuilder;
use Leprz\Boilerplate\Builder\PhpFileContentBuilder;
use Leprz\Boilerplate\Configuration;
use Leprz\Boilerplate\Generator;
use Leprz\Boilerplate\PathNode\File;
use Leprz\Boilerplate\PathNode\Php\PhpFile;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @package Leprz\Boilerplate\Tests
 * @covers \Leprz\Boilerplate\Generator
 * @covers \Leprz\Boilerplate\PathNode\PathNode
 * @covers \Leprz\Boilerplate\PathNode\File
 * @covers \Leprz\Boilerplate\PathNode\Php\PhpFile
 */
class GeneratorTest extends UnitTestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Symfony\Component\Filesystem\Filesystem
     */
    private $filesystemMock;

    /**
     * @var \Leprz\Boilerplate\Configuration|\PHPUnit\Framework\MockObject\MockObject
     */
    private $configurationMock;

    /**
     * @var \Leprz\Boilerplate\Builder\FileBuilder|\PHPUnit\Framework\MockObject\MockObject
     */
    private $fileBuilderMock;

    /**
     * @var \Leprz\Boilerplate\Builder\PhpFileContentBuilder|\PHPUnit\Framework\MockObject\MockObject
     */
    private $phpFileContentBuilderMock;

    public function test_Generate_should_usePhpFileContentBuilder_when_PhpFileIsBuild()
    {
        $this->fileBuilderMock->expects(self::once())->method('createFile');
        $this->phpFileContentBuilderMock->expects(self::once())->method('build');

        $generator = new Generator($this->configurationMock);
        $generator->generate(new PhpFile('test'));
    }

    public function test_Generate_should_useFileBuilder_when_FileIsBuild()
    {
        $this->fileBuilderMock->expects(self::once())->method('createFile');

        $generator = new Generator($this->configurationMock);
        $generator->generate(new File('test', 'yaml'));
    }

    public function test___construct_should_applyConfiguration()
    {
        $this->configurationMock->expects(self::once())->method('getFileBuilder');
        $this->configurationMock->expects(self::once())->method('getPhpFileContentBuilder');

        new Generator($this->configurationMock);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->filesystemMock = $this->createMock(Filesystem::class);
        $this->fileBuilderMock = $this->createMock(FileBuilder::class);
        $this->phpFileContentBuilderMock = $this->createMock(PhpFileContentBuilder::class);
        $this->configurationMock = $this->createMock(Configuration::class);
        $this->configurationMock->method('getFileBuilder')->willReturn($this->fileBuilderMock);
        $this->configurationMock->method('getPhpFileContentBuilder')->willReturn($this->phpFileContentBuilderMock);
    }
}
