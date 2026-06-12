<?php

namespace Codex\Framework\Container;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionParameter;

class Container implements ContainerInterface
{
    private array $services = [];

    public function add(string $id, string|object $concrete = null): void
    {
        if (null === $concrete) {
            $concrete = $id;

            if (!class_exists($id)) {
                throw new ContainerException("Service $id could not be found.");
            }
        }

        $this->services[$id] = $concrete;
    }

    public function get(string $id): object
    {
        if (!$this->has($id)) {
            if (!class_exists($id)) {
                throw new ContainerException("Service $id could not be resolved.");
            }

            $this->add($id);
        }

        $object = $this->resolve($this->services[$id]);
        return $object;
    }

    private function resolve($class): object
    {
        // Instantiate a reflection class
        $reflectionClass = new ReflectionClass($class);

        // use reflection and try to get
        $constructor = $reflectionClass->getConstructor();

        if (null === $constructor) {
            return $reflectionClass->newInstance();
        }

        $constructorParameters = $constructor->getParameters();

        $classDependencies = $this->resolveClassDependencies($constructorParameters);

        $service = $reflectionClass->newInstanceArgs($classDependencies);

        return $service;
    }

    private function resolveClassDependencies(array $reflectionParameters): array
    {
        $classDependencies = [];

        /** @var ReflectionParameter $parameter */
        foreach ($reflectionParameters as $parameter) {
            $serviceType = $parameter->getType();
            dd($serviceType);
            $service = $this->get($serviceType->getName());

            $classDependencies[] = $service;
        }

        return $classDependencies;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }
}