<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2021. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNode\Php;

use Leprz\Boilerplate\PathNode\File;

/**
 * @package Leprz\Boilerplate\PathNode\Php
 */
class PhpFile extends File
{
    /**
     * @var \Leprz\Boilerplate\PathNode\Php\PhpMethod[]
     */
    protected array $methods = [];

    /**
     * @param string $name
     */
    final public function __construct(string $name)
    {
        parent::__construct($name, 'php');
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpMethod $method
     * @return \Leprz\Boilerplate\PathNode\Php\PhpFile
     * @codeCoverageIgnore
     */
    public function addMethod(PhpMethod $method): self
    {
        $this->methods[] = $method;

        return $this;
    }

    /**
     * @return \Leprz\Boilerplate\PathNode\Php\PhpMethod[]
     * @codeCoverageIgnore
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}
