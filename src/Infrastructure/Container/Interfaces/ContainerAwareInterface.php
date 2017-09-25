<?php

namespace Infrastructure\Container\Interfaces;

interface ContainerAwareInterface
{
    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function setContainer(ContainerInterface $container);

    /**
     * Get the container.
     *
     * @return ContainerInterface
     */
    public function getContainer();
}