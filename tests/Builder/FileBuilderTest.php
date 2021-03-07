<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2021. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\Tests\Builder;

use Leprz\Boilerplate\Builder\FileBuilder;
use Leprz\Boilerplate\Exception\FileAlreadyExistsException;
use Leprz\Boilerplate\PathNode\File;
use Leprz\Boilerplate\PathNode\Folder;
use Leprz\Boilerplate\PathNode\Php\PhpFile;
use Symfony\Component\Filesystem\Filesystem;
use Leprz\Boilerplate\Tests\UnitTestCase;

/**
 * @package Leprz\Boilerplate\Tests\Builder
 * @covers \Leprz\Boilerplate\Builder\FileBuilder
 * @uses \Leprz\Boilerplate\PathNode\Folder
 * @uses \Leprz\Boilerplate\PathNode\File
 * @uses \Leprz\Boilerplate\PathNode\PathNode
 */
class FileBuilderTest extends UnitTestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Symfony\Component\Filesystem\Filesystem
     */
    private $filesystemMock;

    /**
     * @var \Leprz\Boilerplate\Builder\FileBuilder
     */
    private FileBuilder $fileBuilder;

    public function test_buildFilePath_should_doSomething()
    {
        $pathToFile = $this->fileBuilder->buildFilePath(
            (new Folder('Test'))
                ->addFile(new File('test', 'yaml'))
        );

        $this->assertEquals(
            str_replace('/', DIRECTORY_SEPARATOR, 'src/Test/test.yaml'),
            $pathToFile
        );
    }

    public function test_createFile_should_doSomething()
    {
        $this->filesystemMock->expects(self::once())->method('dumpFile');
        $this->fileBuilder->createFile(new File('test', 'yaml'), '');
    }

    public function test_createFile_shouldNotAllowToOverrideGeneratedFilesByDefault()
    {
        $this->assertFileOverridingIsNotAllowed();

        $this->filesystemMock->method('exists')->willReturn(true);

        $this->fileBuilder->createFile(new PhpFile('Test'), '');
    }

    public function test_createFile_shouldAllowToOverrideGeneratedFiles_when_OverridingIsEnabled(): void
    {
        $this->filesystemMock->method('exists')->willReturn(true);

        $filePath = $this->fileBuilder->createFile(new PhpFile('Test'), '', true);

        $this->assertNotEmpty($filePath);
    }

    private function assertFileOverridingIsNotAllowed(): void
    {
        $this->expectException(FileAlreadyExistsException::class);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->filesystemMock = $this->createMock(Filesystem::class);
        $this->fileBuilder = new FileBuilder('src' . DIRECTORY_SEPARATOR, $this->filesystemMock);
    }
}
