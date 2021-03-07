<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2021. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\Exception;

use Exception;

class FileAlreadyExistsException extends Exception
{
    /**
     * @param string $filePath
     * @return self
     */
    public static function inPath(string $filePath): self
    {
        return new self(sprintf('File already exits in [%s]', $filePath));
    }
}
