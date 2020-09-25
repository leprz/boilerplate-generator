<?php

declare(strict_types=1);

namespace Leprz\Generator\PathNodeType;

/**
 * @package Leprz\Generator\PathNodeType
 */
class Parameter
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var \Leprz\Generator\PathNodeType\PhpClass|string
     */
    private $type;

    /**
     * @param string $name
     * @param string|\Leprz\Generator\PathNodeType\PhpClass $type
     */
    public function __construct(string $name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \Leprz\Generator\PathNodeType\PhpClass|string
     */
    public function getType()
    {
        return $this->type;
    }
}
