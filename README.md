> Easily generate CRUD, commands, handlers, hexagonal ports, adapters - tailored to your needs.

@leprz/php-code-generator
=========================
![example workflow name](https://github.com/leprz/php-code-generator/workflows/Build/badge.svg)

Introduction
------------
This package helps you generate any kind of file boilerplate (php, yml, etc.) - easily!
Contains a builder for PHP classes, interfaces, functions, methods, parameters and return types.
Generated code is  PSR-12 and PSR-4 complaint.

Installation:

```shell
composer require leprz/php-code-generator
```

Requirements
------------
PHP >= 7.4

Code
----
```php
$this->generator = new Generator(
    new Filesystem(),
    new Configuration(
        'AppPrefix',
        'src'
    )
);

$command = (new Folder('Command'))
    ->addFolder(new Folder('ExampleUseCase'))
    ->addPhpClass(new PhpClass('ExampleCommand'));

$handler = (new Folder('Command'))
    ->addFolder(new Folder('ExampleUseCase'))
    ->addPhpClass(new PhpClass('ExampleHandler'))
    ->addMethod(new Method('__invoke', 'public', 'void', [
        new Parameter('command', $command)
    ]));

$this->generator->generate($command);
$this->generator->generate($handler);
```

will create `src/Command/ExampleUseCase/ExampleCommand.php`
```php
<?php

declare(strict_types=1);

namespace AppPrefix\Command\ExampleUseCase;

/**
 * @package AppPrefix\Command\ExampleUseCase
 */
class ExampleCommand
{
}
```

`src/Command/ExampleUseCase/ExampleHandler.php`
```php
<?php

declare(strict_types=1);

namespace AppPrefix\Command\ExampleUseCase;

/**
 * @package AppPrefix\Command\ExampleUseCase
 */
class ExampleHandler
{
    /**
     * @param \AppPrefix\Command\ExampleUseCase\ExampleCommand
     */
    public function __invoke(ExampleCommand $command): void
    {
    }
}
```
advanced example
```php
$this->testClass1 = (new Folder('Sample'))
    ->addPhpClass(new PhpClass('TestClass1'));

$this->testInterface1 = (new Folder('Sample'))
    ->addPhpInterface(new PhpInterface('TestInterface1'));

$this->testInterface2 = (new Folder('Sample'))
    ->addPhpInterface(new PhpInterface('TestInterface2'))
    ->addMethod(new Method('test', 'public', 'string'));

$this->testClass2 = (new BoundedContext('Domain'))
    ->addLayer(new Layer('Application'))
    ->addFolder(new Folder('Command'))
    ->addPhpClass(new PhpClass('TestClass2'))
    ->extends($this->testClass1)
    ->implements($this->testInterface1, $this->testInterface2)
    ->addMethod(new Method('doSomething', 'public', 'void', [
        new Parameter('testClass1', $this->testClass1),
        new Parameter('test', 'string')
    ]))
    ->addMethod(new Method('doSomethingElse', 'private', $this->testClass1));
```
