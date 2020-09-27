<?php

declare(strict_types=1);

namespace Tests\Builder;

use Leprz\Boilerplate\Builder\FileBuilder;
use Leprz\Boilerplate\PathNodeType\File;
use Leprz\Boilerplate\PathNodeType\Folder;
use Symfony\Component\Filesystem\Filesystem;
use Tests\UnitTestCase;

/**
 * @package Tests\Builder
 * @covers \Leprz\Boilerplate\Builder\FileBuilder
 * @uses \Leprz\Boilerplate\PathNodeType\Folder
 * @uses \Leprz\Boilerplate\PathNodeType\File
 * @uses \Leprz\Boilerplate\PathNodeType\PathNode
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

    protected function setUp(): void
    {
        parent::setUp();

        $this->filesystemMock = $this->createMock(Filesystem::class);
        $this->fileBuilder = new FileBuilder('src' . DIRECTORY_SEPARATOR, $this->filesystemMock);
    }
}
