<?php

declare(strict_types=1);

namespace Tests\PathNode;

use Leprz\Boilerplate\PathNode\File;
use Leprz\Boilerplate\PathNode\Folder;
use Leprz\Boilerplate\PathNode\Php\PhpInterface;
use Tests\UnitTestCase;

/**
 * @package Tests\PathNodeType
 * @covers \Leprz\Boilerplate\PathNode\PathNode
 * @uses \Leprz\Boilerplate\PathNode\Php\PhpFile
 * @uses \Leprz\Boilerplate\PathNode\Php\PhpInterface
 * @uses \Leprz\Boilerplate\PathNode\Folder
 * @uses \Leprz\Boilerplate\PathNode\File
 */
class PathNodeTest extends UnitTestCase
{
    public function test_generateChain_should_returnValidChain()
    {
        $folder1 = new Folder('Test');
        $folder2 = new Folder('Test2');
        $interface = new PhpInterface('Test');

        $phpInterface = ($folder1)
            ->addFolder($folder2)
            ->addPhpInterface($interface);

        $this->assertEquals([$folder1, $folder2, $interface], $phpInterface->generateChain());
    }

    /**
     * @covers \Leprz\Boilerplate\PathNode\File::generateChain
     */
    public function test_generateChain_should_returnSingleValue_when_noParentsAvailable()
    {
        $file = new File('test', 'yaml');
        $this->assertEquals([$file], $file->generateChain());
    }
}
