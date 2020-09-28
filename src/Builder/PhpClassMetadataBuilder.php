<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2020. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\Builder;

use Leprz\Boilerplate\PathNode\PathNode;
use Leprz\Boilerplate\PathNode\Php\PhpClass;

/**
 * @package Leprz\Boilerplate\PathNode
 */
class PhpClassMetadataBuilder
{
    /**
     * @var string
     */
    private string $appPrefix;

    /**
     * @param string $appPrefix
     */
    public function __construct(string $appPrefix)
    {
        $this->appPrefix = $appPrefix;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpClass $class
     * @return string
     */
    public function buildNamespace(PhpClass $class): string
    {
        $chain = $class->generateChain();

        array_pop($chain);

        return $this->concatChunksIntoNamespace($chain);
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpClass $class
     * @return string
     */
    public function buildClassName(PhpClass $class): string
    {
        return $class->getClassName();
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpClass $class
     * @return string
     */
    public function buildUse(PhpClass $class): string
    {
        return $this->concatChunksIntoNamespace($class->generateChain());
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\PathNode[] $chain
     * @return string
     */
    private function concatChunksIntoNamespace(array $chain): string
    {
        if (empty($chain)) {
            return $this->appPrefix;
        }

        $chainOfStrings = array_map(
            static function (PathNode $item) {
                return (string)$item;
            },
            $chain
        );

        return $this->appPrefix . '\\' . implode('\\', $chainOfStrings);
    }
}
