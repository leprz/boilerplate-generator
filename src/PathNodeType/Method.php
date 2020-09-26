<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNodeType;

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
        $this->parameters = $params;
        $this->visibility = $visibility;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|\Leprz\Boilerplate\PathNodeType\PhpClass
     */
    public function getReturnType()
    {
        return $this->returnType;
    }

    /**
     * @return \Leprz\Boilerplate\PathNodeType\Parameter[]
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
}
