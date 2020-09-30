<?php
/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2020. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\Tests;

use Leprz\Boilerplate\Configuration;

/**
 * @package Leprz\Boilerplate\Tests
 * @covers \Leprz\Boilerplate\Configuration
 * @uses \Leprz\Boilerplate\Builder\FileBuilder
 * @uses \Leprz\Boilerplate\Builder\PhpClassMetadataBuilder
 * @uses \Leprz\Boilerplate\Builder\PhpFileContentBuilder
 */
class ConfigurationTest extends UnitTestCase
{
    public function test__construct_should_createAllDefaultGeneratorDependencies(): void
    {
        new Configuration('App', 'src');

        $this->assertTrue(true);
    }

    public function test___construct_should_trimIncorrectBackSlashesFromAppPrefix(): void
    {
        $configuration = new Configuration('\\App\\', 'src');
        $appPrefix = $configuration->getAppPrefix();
        $this->assertEquals('App', $appPrefix);
    }

    protected function setUp(): void
    {
        parent::setUp();
    }
}
