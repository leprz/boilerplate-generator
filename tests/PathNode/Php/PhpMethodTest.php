<?php
/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2020. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\Tests\PathNode\Php;

use InvalidArgumentException;
use Leprz\Boilerplate\PathNode\Php\PhpMethod;
use Leprz\Boilerplate\Tests\UnitTestCase;

/**
 * @package Leprz\Boilerplate\Tests\PathNodeType
 * @covers \Leprz\Boilerplate\PathNode\Php\PhpMethod
 */
class PhpMethodTest extends UnitTestCase
{

    public function test__construct_should_validateParameterType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new PhpMethod('test', 'public', 'void', [
            'parameter'
        ]);
    }

    public function test__construct_should_validateVisibility(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new PhpMethod('test', 'invalid');
    }

    public function test__construct_should_createMethodWithComplexVisibility(): void
    {

        $method = new PhpMethod('test', 'final public static');
        $this->assertEquals('final public static', $method->getVisibility());
    }

    public function test__construct_should_throwException_when_visibilityIsAbstractFinal(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new PhpMethod('test', 'abstract final public');
    }
}
