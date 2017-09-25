<?php

namespace Infrastructure\Container;

use Application\Providers\ApplicationServiceProvider;
use Infrastructure\Container\Definition\DefinitionFactory;
use Infrastructure\Container\Interfaces\ContainerAwareInterface;
use Infrastructure\Container\Interfaces\ContainerInterface;

class ContainerFactory
{
    private static $instance;

    /**
     * Добавлено для обратной совместимости
     * @deprecated
     * @return ContainerInterface
     */
    public static function getInstance(): ContainerInterface
    {
        return self::$instance;
    }

    public static function setInstance(ContainerInterface $container)
    {
        static::$instance = $container;
    }

    public static function create(): ContainerInterface
    {
        $container = new LeagueContainer(null, null, new DefinitionFactory);
        $container->delegate(new ReflectionContainer);

        $container->share(ContainerInterface::class, $container);

        $container->inflector(ContainerAwareInterface::class)
            ->invokeMethod('setContainer', [ContainerInterface::class]);

        $container->addServiceProvider(ApplicationServiceProvider::class);

        static::setInstance($container);

        return $container;
    }
}