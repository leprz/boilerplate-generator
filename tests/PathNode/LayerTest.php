<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2020. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\Tests\PathNode;

use InvalidArgumentException;
use Leprz\Boilerplate\PathNode\Layer;
use Leprz\Boilerplate\Tests\UnitTestCase;

/**
 * @package Leprz\Boilerplate\Tests\PathNodeType
 * @covers \Leprz\Boilerplate\PathNode\Layer
 * @uses \Leprz\Boilerplate\PathNode\PathNode
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
