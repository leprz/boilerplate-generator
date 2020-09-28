<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNode;

/**
 * @package Leprz\Boilerplate\PathNode
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
        parent::__construct($name);
        $this->extension = $extension;
    }

    /**
     * @return \Leprz\Boilerplate\PathNode\PathNode[]
     */
    public function generateChain(): array
    {
        return parent::generateChain();
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getExtension(): string
    {
        return $this->extension;
    }
}
