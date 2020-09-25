<?php

declare(strict_types=1);

namespace Leprz\Generator\PathNodeType;

/**
 * @package Leprz\Generator\PathNodeType
 */
class PhpFile extends File
{
    /**
     * @var \Leprz\Generator\PathNodeType\Method[]
     */
    private array $methods = [];

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct($name, 'php');
    }

    /**
     * @param \Leprz\Generator\PathNodeType\Method $method
     * @return \Leprz\Generator\PathNodeType\PhpFile
     */
    public function addMethod(Method $method): self
    {
        $this->methods[] = $method;

        return $this;
    }

    /**
     * @return \Leprz\Generator\PathNodeType\Method[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}
