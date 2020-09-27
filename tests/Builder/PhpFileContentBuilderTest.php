<?php

declare(strict_types=1);

namespace Tests\Builder;

use Leprz\Boilerplate\Builder\PhpClassMetadataBuilder;
use Leprz\Boilerplate\Builder\PhpFileContentBuilder;
use Leprz\Boilerplate\PathNodeType\Folder;
use Leprz\Boilerplate\PathNodeType\Method;
use Leprz\Boilerplate\PathNodeType\Parameter;
use Leprz\Boilerplate\PathNodeType\PhpClass;
use Leprz\Boilerplate\PathNodeType\PhpFile;
use Leprz\Boilerplate\PathNodeType\PhpInterface;
use Tests\UnitTestCase;

/**
 * @covers \Leprz\Boilerplate\Builder\PhpFileContentBuilder
 * @uses   \Leprz\Boilerplate\Builder\PhpClassMetadataBuilder
 * @uses   \Leprz\Boilerplate\PathNodeType\File
 * @uses   \Leprz\Boilerplate\PathNodeType\PathNode
 * @uses   \Leprz\Boilerplate\PathNodeType\PhpClass
 * @uses   \Leprz\Boilerplate\PathNodeType\PhpFile
 * @uses   \Leprz\Boilerplate\PathNodeType\Method
 * @uses   \Leprz\Boilerplate\PathNodeType\PhpInterface
 * @uses   \Leprz\Boilerplate\PathNodeType\Parameter
 * @uses   \Leprz\Boilerplate\PathNodeType\Folder
 */
class PhpFileContentBuilderTest extends UnitTestCase
{
    private const APP_PREFIX = 'App';

    /**
     * @var \Leprz\Boilerplate\Builder\PhpFileContentBuilder
     */
    private PhpFileContentBuilder $phpFileContentBuilder;

    public function test_build_should_buildPhpFileContent()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(new PhpFile('Test'));

        $this->assertStringContainsString('<?', $phpFileContent);
        $this->assertStringContainsString('declare(strict_types=1);', $phpFileContent);
    }

    public function test_build_should_buildPhpClassContent()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(new PhpClass('TestClass'));

        $this->assertStringContainsString('<?', $phpFileContent);
        $this->assertStringContainsString('declare(strict_types=1);', $phpFileContent);
        $this->assertStringContainsString('namespace ' . self::APP_PREFIX, $phpFileContent);
        $this->assertStringContainsString('class TestClass', $phpFileContent);
    }

    public function test_build_should_buildClassMethod()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(new Method('test', 'public', 'string'))
        );

        $this->assertStringContainsString(
            'public function test(): string{}',
            preg_replace('/(\n|\s{4})/', '', $phpFileContent)
        );
    }

    public function test_build_should_buildClassMethodWithObjectReturnType()
    {
        $returnType = (new Folder('Test'))
            ->addPhpClass(new PhpClass('ReturnTypeClass'));

        // TODO Test/TestClass returned in TestClass will not figure out alias. Create possibility to add alias

        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(new Method('test', 'public', $returnType))
        );

        $this->assertStringContainsString(
            'public function test(): ReturnTypeClass{}',
            preg_replace('/(\n|\s{4})/', '', $phpFileContent)
        );

        $this->assertStringContainsString(
            'use App\Test\ReturnTypeClass;',
            $phpFileContent
        );
    }

    public function test_build_should_buildMethodParameterWithSimpleType()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(
                    new Method(
                        'test',
                        'public',
                        'string',
                        [
                            new Parameter('test', 'string')
                        ]
                    )
                )
        );

        $this->assertStringContainsString(
            'test(string $test)',
            $phpFileContent
        );
    }

    public function test_build_should_buildMethodParameterWithObjectType()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(
                    new Method(
                        'test',
                        'public',
                        'string',
                        [
                            new Parameter(
                                'test',
                                (new Folder('Test'))->addPhpClass(new PhpClass('ParameterType'))
                            )
                        ]
                    )
                )
        );

        $this->assertStringContainsString(
            'test(ParameterType $test)',
            $phpFileContent
        );

        $this->assertStringContainsString(
            sprintf('use %s\Test\ParameterType;', self::APP_PREFIX),
            $phpFileContent
        );
    }

    public function test_build_should_buildPhpInterfaceContent()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(new PhpInterface('TestInterface'));

        $this->assertStringContainsString('<?', $phpFileContent);
        $this->assertStringContainsString('declare(strict_types=1);', $phpFileContent);
        $this->assertStringContainsString('namespace ' . self::APP_PREFIX, $phpFileContent);
        $this->assertStringContainsString('interface TestInterface', $phpFileContent);
    }

    public function test_build_should_buildInterfaceMethod()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpInterface('TestInterface'))
                ->addMethod(new Method('test', 'public', 'string'))
        );

        $this->assertStringContainsString('public function test(): string;', $phpFileContent);
    }

    public function test_build_should_buildClassThatImplementsInterface()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->implements(new PhpInterface('TestInterface'), new PhpInterface('TestInterface2'))
        );

        $this->assertStringContainsString('TestClass implements TestInterface, TestInterface2', $phpFileContent);
    }

    public function test_build_should_buildClassThatExtendsClass()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->extends(new PhpClass('ParentClass'))
        );

        $this->assertStringContainsString('TestClass extends ParentClass', $phpFileContent);
    }

    public function test()
    {
        $phpClassMetadataBuilderMock = $this->createMock(PhpClassMetadataBuilder::class);
        $phpClassMock = $this->createMock(PhpClass::class);

        $phpClassMetadataBuilderMock->expects(self::atLeastOnce())->method('buildNamespace');
        $phpClassMetadataBuilderMock->expects(self::atLeastOnce())->method('buildClassName')->willReturn('Test');

        $phpFileContentBuilder = new PhpFileContentBuilder($phpClassMetadataBuilderMock);
        $phpFileContentBuilder->build($phpClassMock);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->phpFileContentBuilder = new PhpFileContentBuilder(new PhpClassMetadataBuilder(self::APP_PREFIX));
    }
}
