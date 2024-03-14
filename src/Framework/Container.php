<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass;
// use Framework\Exception\Exception;
use ReflectionNamedType;

class Container
{
    private array $definitions = [];
    private array $resolved = [];

    public function addDefinitions(array $newDefinitions): void
    {
        $this->definitions = [...$this->definitions, ...$newDefinitions];
    }

    public function resolve(string $className)
    {
        $reflectionClass = new ReflectionClass($className);


        if (!$reflectionClass->isInstantiable()) {
            throw new \Exception("class {$className} is not instantiable");
        }

        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            return new $className;
        }

        $params = $constructor->getParameters();

        if (count($params) === 0) {
            return new $className;
        }

        $dependencies = [];

        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                throw new \Exception("Failed to resolve class {$className} because {$name} has no type");
            }
            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new \Exception("Failed to resolve class {$className} because invalid param name");
            }

            $dependencies[] = $this->get($type->getName());
        }

        return $reflectionClass->newInstanceArgs($dependencies);
    }

    public function get(string $id)
    {
        if (!array_key_exists($id, $this->definitions)) {
            throw new \Exception("Class {$id} does not exits in the container");
        }
        if (array_key_exists($id, $this->resolved)) {
            return $this->resolved[$id];
        }

        $factory = $this->definitions[$id];
        $dependency = $factory($this);

        $this->resolved[$id] = $dependency;
        return $dependency;
    }
}
