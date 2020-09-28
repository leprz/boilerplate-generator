<?php

declare(strict_types=1);

namespace Leprz\Boilerplate\Builder;

use Leprz\Boilerplate\Exception\ClassContentMalformedException;
use Leprz\Boilerplate\PathNode\File;
use Leprz\Boilerplate\PathNode\Php\PhpClass;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @package App\Tests\Shared\Infrastructure\Generator\Utils\Builder
 */
class FileBuilder
{
    /**
     * @var string
     */
    private string $src;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private Filesystem $filesystem;

    /**
     * @param string $src
     * @param \Symfony\Component\Filesystem\Filesystem $filesystem
     */
    public function __construct(string $src, Filesystem $filesystem)
    {
        //TODO src must have trailing slash at the end
        $this->src = $src;
        $this->filesystem = $filesystem;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\File $file
     * @return string
     */
    public function buildFilePath(File $file): string
    {
        $chain = $file->generateChain();

        return $this->src . implode(DIRECTORY_SEPARATOR, $chain) . '.' . $file->getExtension();
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\File $file
     * @param string $content
     * @return string
     */
    public function createFile(File $file, string $content): string
    {
        $filePath = $this->buildFilePath($file);

        $this->filesystem->dumpFile($filePath, $content);

        return $filePath;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpClass $file
     * @param string $methodContent
     * @return string
     * @throws \Leprz\Boilerplate\Exception\ClassContentMalformedException
     */
    public function appendToFile(PhpClass $file, string $methodContent): string
    {
        $filePath = $this->buildFilePath($file);

        $lines = [];
        foreach (preg_split("/((\r?\n)|(\r\n?))/", rtrim($methodContent)) as $line) {
            $lines[] = '    ' . $line;
        }

        $methodContent = implode("\n", $lines);

        $methodContent = str_replace(': ', ': \\', $methodContent);

        $fileContents = file_get_contents($filePath);

        $lastBracketPosition = strpos($fileContents, '}', -2);

        if ($lastBracketPosition === false) {
            throw new ClassContentMalformedException('Class closing bracket has been not found');
        }

        $fileContents = substr($fileContents, 0, $lastBracketPosition);

        $fileContents .= "\n" . $methodContent . "\n}\n";

        $this->filesystem->dumpFile($filePath, $fileContents);

        return $filePath;
    }
}
