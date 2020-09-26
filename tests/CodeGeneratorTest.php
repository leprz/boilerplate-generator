<?php

declare(strict_types=1);

namespace Tests;

use Leprz\Generator\Generator;
use Leprz\Generator\Configuration;
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
    /**
     * @var \Leprz\Generator\PathNodeType\PhpClass
     */
    private PhpClass $testClass2;

    /**
     * @var \Leprz\Generator\PathNodeType\PhpClass
     */
    private PhpClass $testClass1;

    /**
     * @var \Leprz\Generator\PathNodeType\PhpInterface
     */
    private PhpInterface $testInterface1;

    /**
     * @var \Leprz\Generator\PathNodeType\PhpInterface
     */
    private PhpInterface $testInterface2;

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
        $builder = new ClassMetadataBuilder('App');

        $namespace = $builder->buildNamespace($this->testClass2);

        $this->assertEquals('App\Domain\Application\Command', $namespace);
    }

    public function test_fileBuilderResolver()
    {
        $filesystem = new Filesystem();

        $configuration = new Configuration(
            'Output',
            __DIR__ . DIRECTORY_SEPARATOR . 'output' . DIRECTORY_SEPARATOR
        );

        $yamlContentBuilder = new YamlContentBuilder();
        $configuration->setContentBuilder(YamlFile::class, $yamlContentBuilder);

        $generator = new Generator(
            $filesystem,
            $configuration
        );

        $yaml = (new Folder('YamlTest'))
            ->addFile(
                (new YamlFile('config'))
                    ->addParameter('some_param_name', 'this is some value')
            );

        $generator->generate($yaml);
    }

    public function test_fileGenerator()
    {
        $filesystem = new Filesystem();

        $configuration = new Configuration(
            'Output',
            __DIR__ . DIRECTORY_SEPARATOR . 'output' . DIRECTORY_SEPARATOR
        );

        $configuration->setContentBuilder(YamlFile::class, new YamlContentBuilder());
        $generator = new Generator(
            $filesystem,
            $configuration
        );

        $generator->generate($this->testInterface1);
        $generator->generate($this->testInterface2);
        $generator->generate($this->testClass1);
        $generator->generate($this->testClass2);

        $generator->appendMethod($this->testClass2, new Method('test', 'public', 'string'));
        $generator->appendMethod($this->testClass2, new Method('test1', 'private', $this->testClass2));

        $query = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Query'))
            ->addFolder(new Folder('View'))
            ->addPhpFile(new PhpFile('PhpFile'));

        $generator->generate($query);

        $command = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Command'))
            ->addPhpClass(new PhpClass('DoSomethingCommand'));

        $generator->generate($command);

        $handler = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Command'))
            ->addPhpClass(new PhpClass('DoSomethingHandler'))
            ->addMethod(new Method('handle', 'public', 'void', [
                new Parameter('command', $command)
            ]));

        $generator->generate($handler);

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

        $this->testClass1 = (new Folder('Sample'))
            ->addPhpClass(new PhpClass('TestClass1'));

        $this->testInterface1 = (new Folder('Sample'))
            ->addPhpInterface(new PhpInterface('TestInterface1'));

        $this->testInterface2 = (new Folder('Sample'))
            ->addPhpInterface(new PhpInterface('TestInterface2'))
            ->addMethod(new Method('test', 'public', 'string'));

        $this->testClass2 = (new BoundedContext('Domain'))
            ->addLayer(new Layer('Application'))
            ->addFolder(new Folder('Command'))
            ->addPhpClass(new PhpClass('TestClass2'))
            ->extends($this->testClass1)
            ->implements($this->testInterface1, $this->testInterface2)
            ->addMethod(new Method('doSomething', 'public', 'void', [
                new Parameter('testClass1', $this->testClass1),
                new Parameter('test', 'string')
            ]))
            ->addMethod(new Method('doSomethingElse', 'private', $this->testClass1));
    }
}
