<?php

declare(strict_types=1);

namespace Tests\PathNodeType;

use Leprz\Boilerplate\PathNodeType\File;
use Leprz\Boilerplate\PathNodeType\Folder;
use Leprz\Boilerplate\PathNodeType\PhpInterface;
use Tests\UnitTestCase;

/**
 * @package Tests\PathNodeType
 * @covers \Leprz\Boilerplate\PathNodeType\PathNode
 * @uses \Leprz\Boilerplate\PathNodeType\PhpInterface
 * @uses \Leprz\Boilerplate\PathNodeType\Folder
 * @uses \Leprz\Boilerplate\PathNodeType\PhpFile
 * @uses \Leprz\Boilerplate\PathNodeType\File
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
     * @covers \Leprz\Boilerplate\PathNodeType\File::generateChain
     */
    public function test_generateChain_should_returnSingleValue_when_noParentsAvailable()
    {
        $file = new File('test', 'yaml');
        $this->assertEquals([$file], $file->generateChain());
    }
}
