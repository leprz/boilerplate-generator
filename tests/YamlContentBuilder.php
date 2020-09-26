<?php

declare(strict_types=1);

namespace Tests;

use Leprz\Generator\Builder\ContentBuilderInterface;
use Leprz\Generator\Exception\FileNotSupportedByContentBuilderException;
use Leprz\Generator\PathNodeType\File;

class YamlContentBuilder implements ContentBuilderInterface
{
    private ?YamlFile $file = null;

    /**
     * @return string
     */
    public function build(): string
    {
        $lines = [];
        $parameters = $this->file->getParameters();

        foreach ($parameters as $name => $value) {
            $lines[] = sprintf('%s: "%s"', $name, $value);
        }

        return implode("\n", $lines);
    }

    /**
     * @param \Leprz\Generator\PathNodeType\File $file
     * @throws \Leprz\Generator\Exception\FileNotSupportedByContentBuilderException
     */
    public function setFileIfSupported(File $file)
    {
        if ($file instanceof YamlFile) {
            $this->file = $file;
        } else {
            throw new FileNotSupportedByContentBuilderException(get_class($file));
        }
    }
}
