<?php

namespace Infrastructure\Container\Definition;

use League\Container\Definition\CallableDefinition;
use League\Container\Definition\ClassDefinition;
use League\Container\Definition\DefinitionFactoryInterface;
use League\Container\ImmutableContainerAwareTrait;

class DefinitionFactory implements DefinitionFactoryInterface
{
    use ImmutableContainerAwareTrait;

    /**
     * Заменяет проверку is_callable на instanceof \Closure,
     * Позволяет биндидить существующие объекты с реализованным методом __invoke.
     * @see https://github.com/thephpleague/container/issues/113
     */
    public function getDefinition($alias, $concrete)
    {
        if ($concrete instanceof \Closure) {
            return (new CallableDefinition($alias, $concrete))->setContainer($this->getContainer());
        }

        if (is_string($concrete) && class_exists($concrete)) {
            return (new ClassDefinition($alias, $concrete))->setContainer($this->getContainer());
        }

        // if the item is not defineable we just return the value to be stored
        // in the container as an arbitrary value/instance
        return $concrete;
    }
}
