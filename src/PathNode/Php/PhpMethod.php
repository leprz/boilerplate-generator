<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2021. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNode\Php;

use InvalidArgumentException;
use RuntimeException;

/**
 * @package Leprz\Boilerplate\PathNode\Php
 */
class PhpMethod
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var \Leprz\Boilerplate\PathNode\Php\PhpType|null
     */
    private ?PhpType $returnType;

    /**
     * @var \Leprz\Boilerplate\PathNode\Php\PhpParameter[]
     */
    private array $parameters;

    /**
     * @var string[]
     */
    private array $visibility;

    /**
     * @param string $name
     * @param string $visibility
     * @param \Leprz\Boilerplate\PathNode\Php\PhpType|null $returnType
     * @param \Leprz\Boilerplate\PathNode\Php\PhpParameter[] $params
     */
    public function __construct(string $name, string $visibility = 'public', ?PhpType $returnType = null, $params = [])
    {
        $this->name = $name;

        $this->returnType = $returnType;

        self::validateParameters($params);

        $this->parameters = $params;

        self::validateVisibility($visibility);

        $this->visibility = self::convertVisibilityToArray($visibility);
    }

    private static function convertVisibilityToArray(string $visibility): array
    {
        return explode(' ', $visibility);
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
    public function getReturnType(): ?PhpType
    {
        return $this->returnType;
    }

    /**
     * @return \Leprz\Boilerplate\PathNode\Php\PhpParameter[]
     * @codeCoverageIgnore
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    public function getVisibility(): string
    {
        foreach ($this->visibility as $visibilityPart) {
            if (in_array($visibilityPart, ['public', 'private', 'protected'])) {
                return $visibilityPart;
            }
        }

        throw new RuntimeException('Invalid method visibility');
    }

    /**
     * @param array $params
     */
    private static function validateParameters(array $params): void
    {
        foreach ($params as $param) {
            if (!($param instanceof PhpParameter)) {
                throw new InvalidArgumentException(sprintf('Method parameter must be type %s', PhpParameter::class));
            }
        }
    }

    private static function validateVisibility(string $visibility): void
    {
        $visibilityParts = self::convertVisibilityToArray($visibility);

        foreach ($visibilityParts as $visibilityPart) {
            if (!in_array($visibilityPart, ['final', 'private', 'protected', 'public', 'static'])) {
                throw new InvalidArgumentException('Invalid method visibility ' . $visibility);
            }
        }
    }

    public function isFinal(): bool
    {
        return in_array('final', $this->visibility);
    }

    public function isStatic(): bool
    {
        return in_array('static', $this->visibility);
    }
}
