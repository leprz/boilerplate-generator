<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNode\Php;

/**
 * @package Leprz\Boilerplate\PathNode\Php
 */
class PhpParameter
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var \Leprz\Boilerplate\PathNode\Php\PhpClass|string
     */
    private $type;

    /**
     * @param string $name
     * @param string|\Leprz\Boilerplate\PathNode\Php\PhpClass $type
     * @codeCoverageIgnore
     */
    public function __construct(string $name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \Leprz\Boilerplate\PathNode\Php\PhpClass|string
     * @codeCoverageIgnore
     */
    public function getType()
    {
        return $this->type;
    }
}
