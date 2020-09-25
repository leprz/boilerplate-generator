<?php

declare(strict_types=1);

namespace Leprz\Generator\Builder;

use Leprz\Generator\PathNodeType\PhpClass;
use Leprz\Generator\PathNodeType\PhpFile;
use Leprz\Generator\PathNodeType\PhpInterface;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\Parameter;
use Nette\PhpGenerator\PhpFile as PhpFileGen;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use PhpParser\Comment\Doc;

/**
 * @package Leprz\Generator\Builder
 */
class ClassContentBuilder
{
    /**
     * @var \Leprz\Generator\Builder\ClassMetadataBuilder
     */
    private ClassMetadataBuilder $classMetadataBuilder;

    /**
     * @var \Nette\PhpGenerator\PsrPrinter
     */
    private PsrPrinter $psrPrinter;

    /**
     * @param \Leprz\Generator\Builder\ClassMetadataBuilder $classMetadataBuilder
     */
    public function __construct(
        ClassMetadataBuilder $classMetadataBuilder
    ) {
        $this->psrPrinter = new PsrPrinter();
        $this->classMetadataBuilder = $classMetadataBuilder;
    }

    /**
     * @param \Leprz\Generator\PathNodeType\PhpFile $phpFile
     * @return string
     */
    public function build(PhpFile $phpFile): string
    {
        $psrPrinter = new PsrPrinter();

        $fileContent = $this->buildFileOpening(true);

        if ($phpFile instanceof PhpClass) {
            $classType = $this->toClassType($phpFile);

            $namespace = $this->toNamespace($phpFile);

            $classType->setMethods($this->toMethods($phpFile, $namespace));

            $namespace->add($classType);

            if ($phpFile instanceof PhpInterface) {
                $classType->setInterface();
            }

            return $fileContent . "\n" . $psrPrinter->printNamespace($namespace);
        }

        return $fileContent;
    }

    /**
     * @param \Leprz\Generator\PathNodeType\Method $method
     * @return string
     * @throws \Nette\InvalidStateException
     */
    public function buildMethod(\Leprz\Generator\PathNodeType\Method $method): string
    {
        return $this->psrPrinter->printMethod($this->toMethod($method));
    }

    /**
     * @param bool $strictTypes
     * @return string
     */
    private function buildFileOpening(bool $strictTypes): string
    {
        $fileGen = new PhpFileGen();

        if ($strictTypes === true) {
            $fileGen->setStrictTypes();
        }

        return $this->psrPrinter->printFile($fileGen);
    }

    /**
     * @param \Leprz\Generator\PathNodeType\PhpClass $phpClass
     * @return \Nette\PhpGenerator\ClassType
     */
    private function toClassType(PhpClass $phpClass): ClassType
    {
        $className = $this->classMetadataBuilder->buildClassName($phpClass);
        $classType = new ClassType($className);

        $namespace = $this->classMetadataBuilder->buildNamespace($phpClass);
        $classType->addComment('@package ' . $namespace);

        return $classType;
    }

    /**
     * @param \Leprz\Generator\PathNodeType\PhpClass $phpClass
     * @return \Nette\PhpGenerator\PhpNamespace
     */
    private function toNamespace(PhpClass $phpClass): PhpNamespace
    {
        return new PhpNamespace($this->classMetadataBuilder->buildNamespace($phpClass));
    }

    /**
     * @param \Leprz\Generator\PathNodeType\Method $phpClassMethod
     * @param \Nette\PhpGenerator\PhpNamespace|null $namespace
     * @return \Nette\PhpGenerator\Method
     * @throws \Nette\InvalidStateException
     */
    private function toMethod(
        \Leprz\Generator\PathNodeType\Method $phpClassMethod,
        ?PhpNamespace $namespace = null
    ): Method {
        $method = new Method($phpClassMethod->getName());

        $method->setVisibility($phpClassMethod->getVisibility());

        $parameters = [];

        $phpClassParameters = $phpClassMethod->getParameters();

        foreach ($phpClassParameters as $phpClassParameter) {
            $parameter = new Parameter($phpClassParameter->getName());

            if ($phpClassParameterType = $phpClassParameter->getType()) {
                if ($phpClassParameterType instanceof PhpClass) {
                    $parameterTypeClassName = $this->classMetadataBuilder->buildUse($phpClassParameterType);

                    $method->addComment((string)new Doc(sprintf('@param \%s', $parameterTypeClassName)));
                    $parameter->setType($parameterTypeClassName);
                }

                if (is_string($phpClassParameterType)) {
                    $method->addComment((string)new Doc(sprintf('@param %s', $phpClassParameterType)));
                    $parameter->setType($phpClassParameterType);
                }

                $parameters[] = $parameter;
            }
        }

        $method->setParameters($parameters);

        $phpClassReturnType = $phpClassMethod->getReturnType();

        if ($phpClassReturnType instanceof PhpClass) {
            $returnTypeClassName = $this->classMetadataBuilder->buildUse($phpClassReturnType);

            if ($namespace !== null) {
                $namespace->addUse($returnTypeClassName);
            }

            $method->setReturnType($returnTypeClassName);

            $method->addComment(
                (string)new Doc(
                    sprintf('@return \%s', $returnTypeClassName)
                )
            );
        }

        if (is_string($phpClassReturnType)) {
            $method->setReturnType($phpClassReturnType);
        }
        return $method;
    }

    /**
     * @param \Leprz\Generator\PathNodeType\PhpClass $phpClass
     * @param \Nette\PhpGenerator\PhpNamespace $namespace
     * @return \Nette\PhpGenerator\Method[]
     */
    private function toMethods(PhpClass $phpClass, PhpNamespace $namespace): array
    {
        $methods = [];

        if ($phpClassMethods = $phpClass->getMethods()) {
            foreach ($phpClassMethods as $phpClassMethod) {
                $method = $this->toMethod($phpClassMethod, $namespace);

                $methods[] = $method;
            }
        }

        return $methods;
    }
}
