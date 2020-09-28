<?php

/*
 *
 * This file is part of leprz/boilerplate-generator
 *
 * Copyright (c) 2020. Przemek Łęczycki <leczycki.przemyslaw@gmail.com>
 */

declare(strict_types=1);

namespace Leprz\Boilerplate\Builder;

use Leprz\Boilerplate\PathNode\Php\PhpClass;
use Leprz\Boilerplate\PathNode\Php\PhpFile;
use Leprz\Boilerplate\PathNode\Php\PhpInterface;
use Leprz\Boilerplate\PathNode\Php\PhpMethod;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile as PhpFileGen;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use PhpParser\Comment\Doc;

/**
 * @package Leprz\Boilerplate\Builder
 */
class PhpFileContentBuilder
{
    /**
     * @var \Leprz\Boilerplate\Builder\PhpClassMetadataBuilder
     */
    private PhpClassMetadataBuilder $classMetadataBuilder;

    /**
     * @var \Nette\PhpGenerator\PsrPrinter
     */
    private PsrPrinter $psrPrinter;

    /**
     * @param \Leprz\Boilerplate\Builder\PhpClassMetadataBuilder $classMetadataBuilder
     */
    public function __construct(
        PhpClassMetadataBuilder $classMetadataBuilder
    ) {
        $this->psrPrinter = new PsrPrinter();
        $this->classMetadataBuilder = $classMetadataBuilder;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpFile $phpFile
     * @return string
     */
    public function build(PhpFile $phpFile): string
    {
        $psrPrinter = new PsrPrinter();

        $phpFileContent = $this->buildPhpFile(true);

        if ($phpFile instanceof PhpClass) {
            $namespace = $this->toNamespace($phpFile);

            $class = $this->toClassType($phpFile, $namespace);

            if ($phpFile instanceof PhpInterface) {
                $class->setInterface();
            }

            if ($phpClassMethods = $phpFile->getMethods()) {
                foreach ($phpClassMethods as $phpClassMethod) {
                    $this->addMethod($phpClassMethod, $class, $namespace);
                }
            }

            $namespace->add($class);

            return $phpFileContent . "\n" . $psrPrinter->printNamespace($namespace);
        }

        return $phpFileContent;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpMethod $phpMethod
     * @return string
     * @throws \Nette\InvalidStateException
     */
    public function buildMethod(PhpMethod $phpMethod): string
    {
        $method = new Method($phpMethod->getName());
        $method
            ->setParameters($this->toParameters($phpMethod, $method))
            ->setVisibility($phpMethod->getVisibility());

        $this->addReturnType($phpMethod, $method);

        return $this->psrPrinter->printMethod($method);
    }

    /**
     * @param bool $strictTypes
     * @return string
     */
    private function buildPhpFile(bool $strictTypes): string
    {
        $fileGen = new PhpFileGen();

        if ($strictTypes === true) {
            $fileGen->setStrictTypes();
        }

        return $this->psrPrinter->printFile($fileGen);
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpClass $phpClass
     * @param \Nette\PhpGenerator\PhpNamespace $namespace
     * @return \Nette\PhpGenerator\ClassType
     */
    private function toClassType(PhpClass $phpClass, PhpNamespace $namespace): ClassType
    {
        $className = $this->classMetadataBuilder->buildClassName($phpClass);
        $namespaceName = $this->classMetadataBuilder->buildNamespace($phpClass);

        $class = new ClassType($className);
        $class->addComment('@package ' . $namespaceName);

        if ($extends = $phpClass->getExtends()) {
            $use = $this->classMetadataBuilder->buildUse($extends);
            $namespace->addUse($use);
            $class->addExtend($use);
        }

        $implements = $phpClass->getImplements();

        foreach ($implements as $implement) {
            $use = $this->classMetadataBuilder->buildUse($implement);
            $namespace->addUse($use);
            $class->addImplement($use);
        }

        return $class;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpClass $phpClass
     * @return \Nette\PhpGenerator\PhpNamespace
     */
    private function toNamespace(PhpClass $phpClass): PhpNamespace
    {
        return new PhpNamespace($this->classMetadataBuilder->buildNamespace($phpClass));
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpMethod $phpClassMethod
     * @param \Nette\PhpGenerator\ClassType $class
     * @param \Nette\PhpGenerator\PhpNamespace|null $namespace
     * @return \Nette\PhpGenerator\Method
     */
    private function addMethod(
        PhpMethod $phpClassMethod,
        ClassType $class,
        ?PhpNamespace $namespace = null
    ): Method {
        $method = $class
            ->addMethod($phpClassMethod->getName())
            ->setVisibility($phpClassMethod->getVisibility());

        $method->setParameters($this->toParameters($phpClassMethod, $method, $namespace));

        $this->addReturnType($phpClassMethod, $method, $namespace);

        return $method;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpMethod $phpClassMethod
     * @param \Nette\PhpGenerator\Method $method
     * @param \Nette\PhpGenerator\PhpNamespace|null $namespace
     * @return \Nette\PhpGenerator\Parameter[]
     */
    private function toParameters(
        PhpMethod $phpClassMethod,
        Method $method,
        ?PhpNamespace $namespace = null
    ): array {
        $parameters = [];
        $phpClassParameters = $phpClassMethod->getParameters();

        foreach ($phpClassParameters as $phpClassParameter) {
            $parameter = $method->addParameter($phpClassParameter->getName());

            if ($phpClassParameterType = $phpClassParameter->getType()) {
                if ($phpClassParameterType instanceof PhpClass) {
                    $parameterTypeClassName = $this->classMetadataBuilder->buildUse($phpClassParameterType);

                    if ($namespace) {
                        $namespace->addUse($parameterTypeClassName);
                    }

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
        return $parameters;
    }

    /**
     * @param \Leprz\Boilerplate\PathNode\Php\PhpMethod $phpClassMethod
     * @param \Nette\PhpGenerator\Method $method
     * @param \Nette\PhpGenerator\PhpNamespace|null $namespace
     */
    private function addReturnType(
        PhpMethod $phpClassMethod,
        Method $method,
        ?PhpNamespace $namespace = null
    ): void {
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
    }
}
