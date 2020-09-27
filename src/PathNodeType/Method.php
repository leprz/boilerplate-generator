<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNodeType;

use InvalidArgumentException;

/**
 * @package Leprz\Boilerplate\PathNodeType
 */
class Method
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string|\Leprz\Boilerplate\PathNodeType\PhpClass
     */
    private $returnType;

    /**
     * @var \Leprz\Boilerplate\PathNodeType\Parameter[]
     */
    private array $parameters;

    /**
     * @var string
     */
    private string $visibility;

    /**
     * @param string $name
     * @param string $visibility
     * @param string $returnType
     * @param \Leprz\Boilerplate\PathNodeType\Parameter[] $params
     */
    public function __construct(string $name, string $visibility = 'public', $returnType = 'void', $params = [])
    {
        $this->name = $name;
        $this->returnType = $returnType;

        $this->validateParameters($params);

        $this->parameters = $params;

        $this->validateVisibility($visibility);

        $this->visibility = $visibility;
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
     * @return string|\Leprz\Boilerplate\PathNodeType\PhpClass
     * @codeCoverageIgnore
     */
    public function getReturnType()
    {
        return $this->returnType;
    }

    /**
     * @return \Leprz\Boilerplate\PathNodeType\Parameter[]
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
        return $this->visibility;
    }

    /**
     * @param array $params
     */
    private function validateParameters(array $params): void
    {
        foreach ($params as $param) {
            if (!($param instanceof Parameter)) {
                throw new InvalidArgumentException(sprintf('Method parameter must be type %s', Parameter::class));
            }
        }
    }

    private function validateVisibility(string $visibility): void
    {
        $visibilityParts = explode(' ', $visibility);

        if (in_array('final', $visibilityParts) && in_array('abstract', $visibilityParts)) {
            throw new InvalidArgumentException('Can not use abstract and final for visibility');
        }

        foreach ($visibilityParts as $visibilityPart) {
            if (!in_array($visibilityPart, ['final', 'private', 'public', 'static', 'abstract'])) {
                throw new InvalidArgumentException('Invalid method visibility ' . $visibility);
            }
        }
    }
}
