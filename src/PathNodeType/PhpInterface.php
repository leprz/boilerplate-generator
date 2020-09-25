<?php

declare(strict_types=1);

namespace Leprz\Generator\PathNodeType;

/**
 * @package Leprz\Generator\PathNodeType
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
