<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNodeType;

/**
 * @package Leprz\Boilerplate\PathNodeType
 */
class PhpInterface extends PhpClass
{
    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->name;
    }
}
