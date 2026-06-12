<?php

namespace Codex\Framework\Tests;

use Codex\Framework\Container\Container;
use Codex\Framework\Container\ContainerException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    #[Test]
    public function a_service_can_be_retrieved_from_the_container()
    {
        $container = new Container();

        // id string, concrete class name string | object
        $container->add('dependant-class', DependantClass::class);

        $this->assertInstanceOf(DependantClass::class, $container->get('dependant-class'));
    }

    #[Test]
    public function a_ContainerException_thrown_if_a_service_cannot_be_found()
    {
        $container = new Container();

        $this->expectException(ContainerException::class);
        $container->add('foo-bar');
    }

    #[Test]
    public function checks_a_service_is_already_in_the_container()
    {
        $container = new Container();
        $container->add('dependant-class', DependantClass::class);

        $this->assertTrue($container->has('dependant-class'));
        $this->assertFalse($container->has('other-class'));
    }

    #[Test]
    public function a_service_can_be_recursively_autowired()
    {
        $container = new Container();

        $container->add('dependent-class', DependentClass::class);

        $dependentService = $container->get('dependent-class');

        $this->assertInstanceOf(DependentClass::class, $dependentService);
    }
}