<?php

declare(strict_types=1);

namespace Leprz\Generator\Builder;

use Leprz\Generator\PathNodeType\PathNode;
use Leprz\Generator\PathNodeType\PhpClass;

/**
 * @package Leprz\Generator\PathNodeType
 */
class ClassMetadataBuilder
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
     * @param \Leprz\Generator\PathNodeType\PhpClass $class
     * @return string
     */
    public function buildNamespace(PhpClass $class): string
    {
        $chain = $class->generateChain();

        array_pop($chain);

        return $this->concatChunksIntoNamespace($chain);
    }

    /**
     * @param \Leprz\Generator\PathNodeType\PhpClass $class
     * @return string
     */
    public function buildClassName(PhpClass $class): string
    {
        return $class->getClassName();
    }

    /**
     * @param \Leprz\Generator\PathNodeType\PhpClass $class
     * @return string
     */
    public function buildUse(PhpClass $class): string
    {
        return $this->concatChunksIntoNamespace($class->generateChain());
    }

    /**
     * @param \Leprz\Generator\PathNodeType\PathNode[] $chain
     * @return string
     */
    private function concatChunksIntoNamespace(array $chain): string
    {
        $chainOfStrings = array_map(
            static function (PathNode $item) {
                return (string)$item;
            },
            $chain
        );

        return $this->appPrefix . '\\' . implode('\\', $chainOfStrings);
    }
}
