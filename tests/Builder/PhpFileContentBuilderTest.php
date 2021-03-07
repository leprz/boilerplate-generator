<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2021. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\Tests\Builder;

use Leprz\Boilerplate\Builder\PhpClassMetadataBuilder;
use Leprz\Boilerplate\Builder\PhpFileContentBuilder;
use Leprz\Boilerplate\PathNode\Folder;
use Leprz\Boilerplate\PathNode\Php\PhpMethod;
use Leprz\Boilerplate\PathNode\Php\PhpParameter;
use Leprz\Boilerplate\PathNode\Php\PhpClass;
use Leprz\Boilerplate\PathNode\Php\PhpFile;
use Leprz\Boilerplate\PathNode\Php\PhpInterface;
use Leprz\Boilerplate\PathNode\Php\PhpTrait;
use Leprz\Boilerplate\PathNode\Php\PhpType;
use Leprz\Boilerplate\Tests\UnitTestCase;

/**
 * @covers \Leprz\Boilerplate\Builder\PhpFileContentBuilder
 * @uses   \Leprz\Boilerplate\Builder\PhpClassMetadataBuilder
 * @uses   \Leprz\Boilerplate\PathNode\File
 * @uses   \Leprz\Boilerplate\PathNode\PathNode
 * @uses   \Leprz\Boilerplate\PathNode\Php\PhpClass
 * @uses   \Leprz\Boilerplate\PathNode\Php\PhpFile
 * @uses   \Leprz\Boilerplate\PathNode\Php\PhpMethod
 * @uses   \Leprz\Boilerplate\PathNode\Php\PhpType
 * @uses   \Leprz\Boilerplate\PathNode\Php\PhpInterface
 * @uses   \Leprz\Boilerplate\PathNode\Php\PhpParameter
 * @uses   \Leprz\Boilerplate\PathNode\Folder
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
                ->addMethod(new PhpMethod('test', 'public', PhpType::string()))
        );

        $this->assertStringContainsString(
            'public function test(): string{}',
            preg_replace('/(\n|\s{4})/', '', $phpFileContent)
        );
    }

    public function test_build_should_buildClassMethodWithNoReturnType()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(new PhpMethod('test', 'public', null))
        );

        $this->assertStringNotContainsString(
            '@return',
            preg_replace('/(\n|\s{4})/', '', $phpFileContent)
        );

        $this->assertStringContainsString(
            'public function test(){}',
            preg_replace('/(\n|\s{4})/', '', $phpFileContent)
        );
    }

    public function test_build_should_buildClassMethodWithSimpleReturnType()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(new PhpMethod('test', 'public', PhpType::string()))
        );

        $this->assertStringContainsString(
            '@return string',
            preg_replace('/(\n|\s{4})/', '', $phpFileContent)
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
                ->addMethod(new PhpMethod('test', 'public', PhpType::object($returnType)))
        );

        $this->assertStringContainsString(
            sprintf('use %s\Test\ReturnTypeClass;', self::APP_PREFIX),
            $phpFileContent
        );

        $this->assertStringContainsString(
            sprintf('@return \%s\Test\ReturnTypeClass', self::APP_PREFIX),
            preg_replace('/(\n|\s{4})/', '', $phpFileContent)
        );

        $this->assertStringContainsString(
            'public function test(): ReturnTypeClass{}',
            preg_replace('/(\n|\s{4})/', '', $phpFileContent)
        );
    }

    public function test_build_should_buildClassMethodWithArraySimpleReturnType()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(new PhpMethod('test', 'public', PhpType::array()))
        );

        $this->assertStringContainsString(
            '@return array',
            preg_replace('/(\n|\s{4})/', '', $phpFileContent)
        );

        $this->assertStringContainsString(
            'public function test(): array{}',
            preg_replace('/(\n|\s{4})/', '', $phpFileContent)
        );
    }

    public function test_build_should_buildClassMethodWithArrayOfObjectsReturnType()
    {
        $returnType = (new Folder('Test'))
            ->addPhpClass(new PhpClass('ReturnTypeClass'));

        // TODO Test/TestClass returned in TestClass will not figure out alias. Create possibility to add alias

        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(new PhpMethod('test', 'public', PhpType::array($returnType)))
        );

        $this->assertStringContainsString(
            '@return \App\Test\ReturnTypeClass[]',
            preg_replace('/(\n|\s{4})/', '', $phpFileContent)
        );

        $this->assertStringContainsString(
            'public function test(): array{}',
            preg_replace('/(\n|\s{4})/', '', $phpFileContent)
        );

        $this->assertStringContainsString(
            'use App\Test\ReturnTypeClass;',
            $phpFileContent
        );
    }

    public function test_build_should_buildMethodParameterWithNoType()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(
                    new PhpMethod(
                        'test',
                        'public',
                        null,
                        [
                            new PhpParameter('test')
                        ]
                    )
                )
        );

        $this->assertStringNotContainsString(
            '@param',
            $phpFileContent
        );

        $this->assertStringContainsString(
            'test($test)',
            $phpFileContent
        );
    }

    public function test_build_should_buildMethodParameterWithSimpleType()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(
                    new PhpMethod(
                        'test',
                        'public',
                        null,
                        [
                            new PhpParameter('test', PhpType::string())
                        ]
                    )
                )
        );

        $this->assertStringContainsString(
            '@param string',
            $phpFileContent
        );

        $this->assertStringContainsString(
            'test(string $test)',
            $phpFileContent
        );
    }

    public function test_build_should_buildMethodParameterWithSimpleObject()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(
                    new PhpMethod(
                        'test',
                        'public',
                        PhpType::string(),
                        [
                            new PhpParameter('test', PhpType::object())
                        ]
                    )
                )
        );

        $this->assertStringContainsString(
            'test(object $test)',
            $phpFileContent
        );

        $this->assertStringContainsString(
            '@param object',
            $phpFileContent
        );
    }

    public function test_build_should_buildMethodParameterWithObjectOfType()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(
                    new PhpMethod(
                        'test',
                        'public',
                        PhpType::string(),
                        [
                            new PhpParameter(
                                'test',
                                PhpType::object(
                                    (new Folder('Test'))->addPhpClass(new PhpClass('ParameterType'))
                                )
                            )
                        ]
                    )
                )
        );

        $this->assertStringContainsString(
            sprintf('use %s\Test\ParameterType;', self::APP_PREFIX),
            $phpFileContent
        );

        $this->assertStringContainsString(
            sprintf('@param \%s\Test\ParameterType', self::APP_PREFIX),
            $phpFileContent
        );

        $this->assertStringContainsString(
            'test(ParameterType $test)',
            $phpFileContent
        );
    }

    public function test_build_should_buildMethodParameterWithSimpleArrayOfType()
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(
                    new PhpMethod(
                        'test',
                        'public',
                        PhpType::string(),
                        [
                            new PhpParameter(
                                'test',
                                PhpType::array()
                            )
                        ]
                    )
                )
        );

        $this->assertStringContainsString(
            '@param array',
            $phpFileContent
        );

        $this->assertStringContainsString(
            'test(array $test)',
            $phpFileContent
        );
    }

    public function test_build_should_buildMethodParameterWithSimpleArrayType()
    {
        $ofType = (new Folder('Test'))
            ->addPhpClass(new PhpClass('ArrayTypeClass'));

        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpClass('TestClass'))
                ->addMethod(
                    new PhpMethod(
                        'test',
                        'public',
                        PhpType::string(),
                        [
                            new PhpParameter(
                                'test',
                                PhpType::array($ofType)
                            )
                        ]
                    )
                )
        );

        $this->assertStringContainsString(
            sprintf('@param \%s\Test\ArrayTypeClass[]', self::APP_PREFIX),
            $phpFileContent
        );

        $this->assertStringContainsString(
            'test(array $test)',
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
                ->addMethod(new PhpMethod('test', 'public', PhpType::string()))
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

    public function test_build_should_buildTrait(): void
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpTrait('TestTrait'))
        );

        $this->assertStringContainsString('trait TestTrait', $phpFileContent);
    }

    public function test_build_should_buildTrait_withMethod(): void
    {
        $phpFileContent = $this->phpFileContentBuilder->build(
            (new PhpTrait('TestTrait'))->addMethod(new PhpMethod('test', 'public', PhpType::void()))
        );

        $this->assertStringContainsString('public function test(): void', $phpFileContent);
    }

    public function test_build_should_allowToUseTraitInClasses(): void
    {
        $trait = new PhpTrait('TestTrait');

        $phpFileContent = $this->phpFileContentBuilder->build(
            (new Folder('Test'))->addPhpClass(new PhpClass('TestClass'))->useTraits($trait)
        );

        $this->assertStringContainsString('use App\TestTrait;', $phpFileContent);
        $this->assertStringContainsString('use TestTrait', $phpFileContent);
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
