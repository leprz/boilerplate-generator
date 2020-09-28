<?php

declare(strict_types=1);

namespace Tests\Builder;

use Leprz\Boilerplate\Builder\PhpClassMetadataBuilder;
use Leprz\Boilerplate\PathNode\Folder;
use Leprz\Boilerplate\PathNode\Php\PhpClass;
use Tests\UnitTestCase;

/**
 * @package Tests\Builder
 * @covers \Leprz\Boilerplate\Builder\PhpClassMetadataBuilder
 * @uses \Leprz\Boilerplate\PathNode\Php\PhpFile
 * @uses \Leprz\Boilerplate\PathNode\Php\PhpClass
 * @uses \Leprz\Boilerplate\PathNode\Folder
 * @uses \Leprz\Boilerplate\PathNode\File
 * @uses \Leprz\Boilerplate\PathNode\PathNode
 */
class PhpClassMetadataBuilderTest extends UnitTestCase
{

    /**
     * @var \Leprz\Boilerplate\Builder\PhpClassMetadataBuilder
     */
    private PhpClassMetadataBuilder $phpClassMetadataBuilder;

    public function test_buildClassName_should_returnValidClassName()
    {
        $className = $this->phpClassMetadataBuilder->buildClassName(new PhpClass('Test'));
        $this->assertEquals('Test', $className);
    }

    public function test_BuildNamespace_should_returnValidNamespace()
    {
        $namespace = $this->phpClassMetadataBuilder->buildNamespace(new PhpClass('Test'));
        $nestedNamespace = $this->phpClassMetadataBuilder->buildNamespace(
            (new Folder('Test'))->addPhpClass(
                new PhpClass('Test')
            )
        );

        $this->assertEquals('App', $namespace);
        $this->assertEquals('App\Test', $nestedNamespace);
    }

    public function test_BuildUse_should_returnValidUse()
    {
        $use = $this->phpClassMetadataBuilder->buildUse(new PhpClass('Test'));
        $this->assertEquals('App\Test', $use);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->phpClassMetadataBuilder = new PhpClassMetadataBuilder('App');
    }
}
