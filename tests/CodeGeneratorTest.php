<?php

declare(strict_types=1);

namespace Tests;

use Leprz\Generator\Generator;
use Leprz\Generator\Configuration;
use Leprz\Generator\Builder\FileBuilder;
use Leprz\Generator\Builder\ClassMetadataBuilder;
use Leprz\Generator\PathNodeType\BoundedContext;
use Leprz\Generator\PathNodeType\Folder;
use Leprz\Generator\PathNodeType\File;
use Leprz\Generator\PathNodeType\Layer;
use Leprz\Generator\PathNodeType\Method;
use Leprz\Generator\PathNodeType\PathNode;
use Leprz\Generator\PathNodeType\Parameter;
use Leprz\Generator\PathNodeType\PhpClass;
use Leprz\Generator\PathNodeType\PhpFile;
use Leprz\Generator\PathNodeType\PhpInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @package App\Tests\Shared\Infrastructure\Generator
 */
class CodeGeneratorTest extends UnitTestCase
{
    private PhpClass $phpClass;

    public function test_GenerateChain_should_returnCorrectlyOrderedArray(): void
    {
        $this->assertEquals(
            ['Domain', 'Application', 'Command', 'Action'],
            array_map(
                static function (PathNode $item) {
                    return (string)$item;
                },
                $this->phpClass->generateChain()
            )
        );
    }

    public function test_fileBuilder_should_buildValidPathForTheClass(): void
    {
        $filesystemMock = $this->createMock(Filesystem::class);

        $builder = new FileBuilder(__DIR__ . DIRECTORY_SEPARATOR . 'dist' . DIRECTORY_SEPARATOR, $filesystemMock);

        $classPath = $builder->buildFilePath($this->phpClass);

        $this->assertEquals(
            str_replace('/', DIRECTORY_SEPARATOR, 'dist/Domain/Application/Command/Action.php'),
            $classPath
        );
    }

    public function test_namespaceBuilder_should_buildValidNamespace(): void
    {
        $builder = new ClassMetadataBuilder('App');

        if ($this->phpClass instanceof PhpClass) {
            $namespace = $builder->buildNamespace($this->phpClass);
        }

        $this->assertEquals('App\Domain\Application\Command', $namespace);
    }

    public function test_fileGenerator()
    {
        $filesystem = new Filesystem();

        $generator = new Generator(
            $filesystem,
            new Configuration(
                'App',
                'dist' . DIRECTORY_SEPARATOR
            )
        );

        $generator->generate($this->phpClass);

        $generator->appendMethod($this->phpClass, new Method('test', 'public', 'void'));
        $generator->appendMethod($this->phpClass, new Method('test1', 'private', $this->phpClass));

        $query = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Query'))
            ->addFolder(new Folder('View'))
            ->addPhpFile(new PhpFile('PhpFile'));

        $generator->generate($query);

        $query = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Query'))
            ->addFolder(new Folder('View'))
            ->addPhpFile(new PhpInterface('PhpInterface'));

        $generator->generate($query);

        $query = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Query'))
            ->addFolder(new Folder('View'))
            ->addFile(new File('file', 'yaml'));

        $generator->generate($query);

        $this->assertTrue(true);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $appFixtures = (new Folder('DataFixtures'))
            ->addPhpFile(new PhpClass('AppFixtures'));

        $this->phpClass = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Command'))
            ->addPhpClass(new PhpClass('Action'))
            ->addMethod(new Method('doSomething', 'public', 'void', [
                new Parameter('appFixtures', $appFixtures),
                new Parameter('test', 'string')
            ]))
            ->addMethod(new Method('doSomethingElse', 'private', $appFixtures));
    }
}
