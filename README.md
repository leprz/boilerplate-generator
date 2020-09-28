> Generate files for CRUD, commands, handlers, ports, adapters, configuration - tailored to your needs.

leprz/boilerplate-generator
=========================
![example workflow name](https://github.com/leprz/php-code-generator/workflows/Build/badge.svg)
[![codecov](https://codecov.io/gh/leprz/boilerplate-generator/branch/master/graph/badge.svg)](https://codecov.io/gh/leprz/boilerplate-generator)

Introduction
------------
This package helps you generate any kind of file boilerplate (php, yml, etc.).
Contains a builder for PHP classes, interfaces, functions, methods, parameters and return types.
Generated code is  PSR-12 and PSR-4 complaint.

**Installation:**

```shell
composer require leprz/boilerplate-generator --dev
```

Requirements
------------
PHP >= 7.4

Code
----
```php
use Leprz\Boilerplate\PathNode\Folder;
use Leprz\Boilerplate\PathNode\Php\PhpClass;
use Leprz\Boilerplate\PathNode\Php\PhpMethod;
use Leprz\Boilerplate\PathNode\Php\PhpParameter;
use Leprz\Boilerplate\Configuration;
use Leprz\Boilerplate\Generator;

$generator = new Generator(
    new Configuration(
        'AppPrefix',
        'src/'
    )
);

$command = (new Folder('Command'))
    ->addFolder(new Folder('ExampleUseCase'))
    ->addPhpClass(new PhpClass('ExampleCommand'));

$handler = (new Folder('Command'))
    ->addFolder(new Folder('ExampleUseCase'))
    ->addPhpClass(new PhpClass('ExampleHandler'))
    ->addMethod(new PhpMethod('__invoke', 'public', 'void', [
        new PhpParameter('command', $command)
    ]));

$generator->generate($command);
$generator->generate($handler);
```

will create file `src/Command/ExampleUseCase/ExampleCommand.php`
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
will create file `src/Command/ExampleUseCase/ExampleHandler.php`
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
use Leprz\Boilerplate\PathNode\BoundedContext;
use Leprz\Boilerplate\PathNode\Layer;
use Leprz\Boilerplate\PathNode\Folder;
use Leprz\Boilerplate\PathNode\Php\PhpClass;
use Leprz\Boilerplate\PathNode\Php\PhpInterface;
use Leprz\Boilerplate\PathNode\Php\PhpMethod;
use Leprz\Boilerplate\PathNode\Php\PhpParameter;

$this->testClass1 = (new Folder('Sample'))
    ->addPhpClass(new PhpClass('TestClass1'));

$this->testInterface1 = (new Folder('Sample'))
    ->addPhpInterface(new PhpInterface('TestInterface1'));

$this->testInterface2 = (new Folder('Sample'))
    ->addPhpInterface(new PhpInterface('TestInterface2'))
    ->addMethod(new PhpMethod('test', 'public', 'string'));

$this->testClass2 = (new BoundedContext('Domain'))
    ->addLayer(new Layer('Application'))
    ->addFolder(new Folder('Command'))
    ->addPhpClass(new PhpClass('TestClass2'))
    ->extends($this->testClass1)
    ->implements($this->testInterface1, $this->testInterface2)
    ->addMethod(new PhpMethod('doSomething', 'public', 'void', [
        new PhpParameter('testClass1', $this->testClass1),
        new PhpParameter('test', 'string')
    ]))
    ->addMethod(new PhpMethod('doSomethingElse', 'private', $this->testClass1));
```
