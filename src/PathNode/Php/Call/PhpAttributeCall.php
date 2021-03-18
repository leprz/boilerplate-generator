<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2021. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNode\Php\Call;

use Leprz\Boilerplate\PathNode\Php\PhpAttribute;

class PhpAttributeCall
{
    /**
     * @var \Leprz\Boilerplate\PathNode\Php\PhpAttribute
     */
    private PhpAttribute $attribute;

    /**
     * @var \Leprz\Boilerplate\PathNode\Php\Call\PhpArgument[]
     */
    private array $arguments = [];

    public function __construct(PhpAttribute $attribute)
    {
        $this->attribute = $attribute;
    }

    public function addArgument(PhpArgument $argument): self
    {
        $this->arguments[] = $argument;

        return $this;
    }

    /**
     * @return \Leprz\Boilerplate\PathNode\Php\PhpAttribute
     */
    public function getAttribute(): PhpAttribute
    {
        return $this->attribute;
    }

    /**
     * @return \Leprz\Boilerplate\PathNode\Php\Call\PhpArgument[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
