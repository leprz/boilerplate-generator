<?php

declare(strict_types=1);

namespace Leprz\Generator\PathNodeType;

/**
 * @package Leprz\Generator\PathNodeType
 */
class File extends PathNode
{
    /**
     * @var string
     */
    protected string $extension = '';

    /**
     * @param string $name
     * @param string $extension
     */
    public function __construct(string $name, string $extension)
    {
        $this->name = $name;
        $this->extension = $extension;
    }

    /**
     * @return \Leprz\Generator\PathNodeType\PathNode[]
     */
    public function generateChain(): array
    {
        return parent::generateChain();
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }
}
