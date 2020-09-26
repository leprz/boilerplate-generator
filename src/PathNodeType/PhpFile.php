<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\PathNodeType;

/**
 * @package Leprz\Boilerplate\PathNodeType
 */
class PhpFile extends File
{
    /**
     * @var \Leprz\Boilerplate\PathNodeType\Method[]
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
     * @param \Leprz\Boilerplate\PathNodeType\Method $method
     * @return \Leprz\Boilerplate\PathNodeType\PhpFile
     */
    public function addMethod(Method $method): self
    {
        $this->methods[] = $method;

        return $this;
    }

    /**
     * @return \Leprz\Boilerplate\PathNodeType\Method[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}
