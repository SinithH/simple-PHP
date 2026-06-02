<?php

namespace Codex\Framework\Tests;

class DependantClass
{
    public function __construct(private DependancyClass $dependancy)
    {
    }

    public function getDependency(): DependancyClass
    {
        return $this->dependancy;
    }
}