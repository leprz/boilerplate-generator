<?php

declare(strict_types=1);

namespace Leprz\Generator\Builder;

use Leprz\Generator\Configuration;
use Leprz\Generator\PathNodeType\File;

class ContentBuilderResolver
{
    /**
     * @var \Leprz\Generator\Configuration
     */
    private Configuration $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param \Leprz\Generator\PathNodeType\File $file
     * @return \Leprz\Generator\Builder\ContentBuilderInterface|null
     * @throws \Leprz\Generator\Exception\FileNotSupportedByContentBuilderException
     */
    public function resolve(File $file): ?ContentBuilderInterface
    {
        $contentBuilders = $this->configuration->getContentBuilders();
        $className = get_class($file);

        if (array_key_exists($className, $contentBuilders)) {
            $foundContentBuilder = $contentBuilders[get_class($file)];

            $foundContentBuilder->setFileIfSupported($file);

            return $foundContentBuilder;
        }

        return null;
    }
}
