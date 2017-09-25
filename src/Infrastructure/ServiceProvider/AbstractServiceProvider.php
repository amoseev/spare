<?php

namespace Infrastructure\ServiceProvider;

use Infrastructure\Container\Interfaces\ContainerInterface as MoreContainerInterface;
use League\Container\ContainerInterface as LeagueContainerInterface;
use League\Container\ServiceProvider\ServiceProviderInterface;

abstract class AbstractServiceProvider implements ServiceProviderInterface
{
    /**
     * @var array
     */
    protected $provides = [];

    /**
     * {@inheritdoc}
     */
    public function provides($alias = null)
    {
        if (!is_null($alias)) {
            return (in_array($alias, $this->provides));
        }

        return $this->provides;
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->overrideForEnvironment();
    }

    /**
     * @var MoreContainerInterface
     */
    protected $container;

    /**
     * Set a container.
     *
     * @param
     * @return MoreContainerInterface
     */
    public function setContainer(LeagueContainerInterface $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get the container.
     *
     * @return MoreContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function getEnvironment(): string
    {
        return getenv('ENV');
    }

    public function overrideForEnvironment()
    {
        if (method_exists($this, $this->getEnvironment())) {
            call_user_func([$this, $this->getEnvironment()]);
        }
    }
}