<?php

declare(strict_types=1);

namespace Tests;

use Leprz\Generator\PathNodeType\File;

class YamlFile extends File
{
    /**
     * @var array<string, string>
     */
    private array $parameters = [];

    public function __construct(string $name)
    {
        parent::__construct($name, 'yaml');
    }

    public function addParameter(string $name, string $value): self
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
