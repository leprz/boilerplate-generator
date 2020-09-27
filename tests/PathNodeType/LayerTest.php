<?php

declare(strict_types=1);

namespace Tests\PathNodeType;

use InvalidArgumentException;
use Leprz\Boilerplate\PathNodeType\Layer;
use Tests\UnitTestCase;

/**
 * @package Tests\PathNodeType
 * @covers \Leprz\Boilerplate\PathNodeType\Layer
 * @uses \Leprz\Boilerplate\PathNodeType\PathNode
 */
class LayerTest extends UnitTestCase
{
    public function test__construct_should_failIfInvalidLayerIsAdded()
    {
        $this->expectException(InvalidArgumentException::class);
        new Layer('App');
    }

    public function test__construct_should_buildValidLayers()
    {
        new Layer('Application');
        new Layer('Infrastructure');
        new Layer('Domain');

        $this->assertTrue(true);
    }
}
