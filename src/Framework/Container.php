<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass;
use Framework\Exception\ContainerException;

class Container
{
    private array $definitions = [];

    public function addDefinitions(array $newDefinitions): void
    {
        $this->definitions = [...$this->definitions, ...$newDefinitions];
        // dd($this->definitions);
    }

    public function resolve(string $className)
    {
        $reflectionClass = new ReflectionClass($className);


        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException("class {$className} is not instantiable");
        }
        dd($reflectionClass);
    }
}
