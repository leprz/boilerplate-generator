<?php

declare(strict_types=1);

namespace Tests;

use Leprz\Boilerplate\Generator;
use Leprz\Boilerplate\Configuration;
use Leprz\Boilerplate\Builder\PhpClassMetadataBuilder;
use Leprz\Boilerplate\PathNode\BoundedContext;
use Leprz\Boilerplate\PathNode\Folder;
use Leprz\Boilerplate\PathNode\File;
use Leprz\Boilerplate\PathNode\Layer;
use Leprz\Boilerplate\PathNode\Php\PhpMethod;
use Leprz\Boilerplate\PathNode\PathNode;
use Leprz\Boilerplate\PathNode\Php\PhpParameter;
use Leprz\Boilerplate\PathNode\Php\PhpClass;
use Leprz\Boilerplate\PathNode\Php\PhpFile;
use Leprz\Boilerplate\PathNode\Php\PhpInterface;

/**
 * @package App\Tests\Shared\Infrastructure\Generator
 */
class GeneratorTest1 extends UnitTestCase
{
    /**
     * @var \Leprz\Boilerplate\PathNode\Php\PhpClass
     */
    private PhpClass $testClass2;

    /**
     * @var \Leprz\Boilerplate\PathNode\Php\PhpClass
     */
    private PhpClass $testClass1;

    /**
     * @var \Leprz\Boilerplate\PathNode\Php\PhpInterface
     */
    private PhpInterface $testInterface1;

    /**
     * @var \Leprz\Boilerplate\PathNode\Php\PhpInterface
     */
    private PhpInterface $testInterface2;

    /**
     * @var \Leprz\Boilerplate\Generator
     */
    private Generator $generator;

    public function test_GenerateChain_should_returnCorrectlyOrderedArray(): void
    {
        $this->assertEquals(
            ['Domain', 'Application', 'Command', 'TestClass2'],
            array_map(
                static function (PathNode $item) {
                    return (string)$item;
                },
                $this->testClass2->generateChain()
            )
        );
    }

  /*  public function test_fileBuilder_should_buildValidPathForTheClass(): void
    {
        $filesystemMock = $this->createMock(Filesystem::class);

        $builder = new FileBuilder(__DIR__ . DIRECTORY_SEPARATOR . 'dist' . DIRECTORY_SEPARATOR, $filesystemMock);

        $classPath = $builder->buildFilePath($this->phpClass);

        $this->assertEquals(
            str_replace('/', DIRECTORY_SEPARATOR, 'dist/Domain/Application/Command/Action.php'),
            $classPath
        );
    }*/

    public function test_namespaceBuilder_should_buildValidNamespace(): void
    {
        $builder = new PhpClassMetadataBuilder('App');

        $namespace = $builder->buildNamespace($this->testClass2);

        $this->assertEquals('App\Domain\Application\Command', $namespace);
    }

    public function test()
    {
        $this->generator = new Generator(
            new Configuration(
                'AppPrefix',
                __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR
            )
        );

        $command = (new Folder('Command'))
            ->addFolder(new Folder('ExampleUseCase'))
            ->addPhpClass(new PhpClass('ExampleCommand'));

        $handler = (new Folder('Command'))
            ->addFolder(new Folder('ExampleUseCase'))
            ->addPhpClass(new PhpClass('ExampleHandler'))
            ->addMethod(new PhpMethod('__invoke', 'public', 'void', [
                new PhpParameter('command', $command)
            ]));

        $this->generator->generate($command);
        $this->generator->generate($handler);

        $this->assertTrue(true);
    }

    public function test_fileGenerator()
    {
        $this->generator->generate($this->testInterface1);
        $this->generator->generate($this->testInterface2);
        $this->generator->generate($this->testClass1);
        $this->generator->generate($this->testClass2);

        $this->generator->appendMethod($this->testClass2, new PhpMethod('test', 'public', 'string'));
        $this->generator->appendMethod($this->testClass2, new PhpMethod('test1', 'private', $this->testClass2));

        $query = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Query'))
            ->addFolder(new Folder('View'))
            ->addPhpFile(new PhpFile('PhpFile'));

        $this->generator->generate($query);

        $command = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Command'))
            ->addPhpClass(new PhpClass('DoSomethingCommand'));

        $this->generator->generate($command);

        $handler = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Command'))
            ->addPhpClass(new PhpClass('DoSomethingHandler'))
            ->addMethod(new PhpMethod('handle', 'public', 'void', [
                new PhpParameter('command', $command)
            ]));

        $this->generator->generate($handler);

        $query = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Query'))
            ->addFolder(new Folder('View'))
            ->addPhpFile(new PhpInterface('PhpInterface'));

        $this->generator->generate($query);

        $query = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Query'))
            ->addFolder(new Folder('View'))
            ->addFile(new File('file', 'yaml'));

        $this->generator->generate($query);

        $this->assertTrue(true);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = new Generator(
            new Configuration(
                'Output',
                __DIR__ . DIRECTORY_SEPARATOR . 'output' . DIRECTORY_SEPARATOR
            )
        );

        $this->testClass1 = (new Folder('Sample'))
            ->addPhpClass(new PhpClass('TestClass1'));

        $this->testInterface1 = (new Folder('Sample'))
            ->addPhpInterface(new PhpInterface('TestInterface1'));

        $this->testInterface2 = (new Folder('Sample'))
            ->addPhpInterface(new PhpInterface('TestInterface2'))
            ->addMethod(new PhpMethod('test', 'public', 'string'));

        $this->testClass2 = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Command'))
            ->addPhpClass(new PhpClass('TestClass2'))
            ->extends($this->testClass1)
            ->implements($this->testInterface1, $this->testInterface2)
            ->addMethod(new PhpMethod('doSomething', 'public', 'void', [
                new PhpParameter('testClass1', $this->testClass1),
                new PhpParameter('test', 'string')
            ]))
            ->addMethod(new PhpMethod('doSomethingElse', 'private', $this->testClass1));
    }
}
