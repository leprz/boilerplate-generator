<?php

declare(strict_types=1);

namespace Leprz\Generator;

/**
 * @package Leprz\Generator\PathNodeType\ValueObject
 */
class Configuration
{
    /**
     * @var string
     */
    private string $appPrefix;

    /**
     * @var string
     */
    private string $appSrc;

    /**
     * @param string $appPrefix
     * @param string $appSrc
     */
    public function __construct(string $appPrefix, string $appSrc)
    {
        $this->appPrefix = $appPrefix;
        $this->appSrc = $appSrc;
    }

    /**
     * @return string
     */
    public function getAppPrefix(): string
    {
        return $this->appPrefix;
    }

    /**
     * @return string
     */
    public function getAppSrc(): string
    {
        return $this->appSrc;
    }
}
