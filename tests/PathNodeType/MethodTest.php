<?php

declare(strict_types=1);

namespace Tests\PathNodeType;

use InvalidArgumentException;
use Leprz\Boilerplate\PathNodeType\Method;
use Tests\UnitTestCase;

/**
 * @package Tests\PathNodeType
 * @covers \Leprz\Boilerplate\PathNodeType\Method
 */
class MethodTest extends UnitTestCase
{

    public function test__construct_should_validateParameterType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Method('test', 'public', 'void', [
            'parameter'
        ]);
    }

    public function test__construct_should_validateVisibility(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Method('test', 'invalid');
    }

    public function test__construct_should_createMethodWithComplexVisibility(): void
    {

        $method = new Method('test', 'final public static');
        $this->assertEquals('final public static', $method->getVisibility());
    }

    public function test__construct_should_throwException_when_visibilityIsAbstractFinal(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Method('test', 'abstract final public');
    }
}
