<?php

namespace Codex\Framework\Container;

use Psr\Container\ContainerInterface;

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
            if (class_exists($id)) {
                throw new ContainerException("Service $id could not be resolved.");
            }

            $this->add($id);
        }

        $object = $this->resolve($this->services[$id]);
        return $object;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }
}