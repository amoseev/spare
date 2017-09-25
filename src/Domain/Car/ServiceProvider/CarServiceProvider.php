<?php

namespace Domain\Car\ServiceProvider;

use Domain\Car\Entity\Car;
use Domain\Car\Repository\CarRepository;
use Infrastructure\DatabaseConnection\Interfaces\EntityManagerInterface;
use Infrastructure\ServiceProvider\AbstractServiceProvider;

class CarServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        CarRepository::class,
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(CarRepository::class, function () use ($container) {
            /** @var EntityManagerInterface $em */
            $em = $container->get(EntityManagerInterface::class);

            return $em->getRepository(Car::class);
        });

        parent::register();
    }
}