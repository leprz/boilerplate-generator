<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2020. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

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
     * @var \Leprz\Boilerplate\PathNode\Php\PhpType|null
     */
    private ?PhpType $type;

    /**
     * @param string $name
     * @param \Leprz\Boilerplate\PathNode\Php\PhpType|null $type
     * @codeCoverageIgnore
     */
    public function __construct(string $name, ?PhpType $type = null)
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
     * @return \Leprz\Boilerplate\PathNode\Php\PhpType|null
     * @codeCoverageIgnore
     */
    public function getType(): ?PhpType
    {
        return $this->type;
    }
}
