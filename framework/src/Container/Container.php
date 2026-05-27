<?php

namespace Codex\Framework\Container;

use Codex\Framework\Tests\DependantClass;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $services = [];
    public function add(string $id, string|object $concrete = null): void
    {
        $this->services[$id] = $concrete;
    }

    public function get(string $id): object
    {
          return new DependantClass();
//        return new $this->services[$id]();
    }

    public function has(string $id): bool
    {
        return 0;// TODO: Implement has() method.
    }
}