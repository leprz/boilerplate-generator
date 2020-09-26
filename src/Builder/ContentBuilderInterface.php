<?php

declare(strict_types=1);

namespace Leprz\Generator\Builder;

use Leprz\Generator\PathNodeType\File;

interface ContentBuilderInterface
{
    public function build(): string;

    public function setFileIfSupported(File $file);
}
