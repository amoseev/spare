<?php

namespace Domain\Car\Service;


use Domain\Car\Entity\Car;
use Domain\Car\Repository\CarRepository;
use Infrastructure\DatabaseConnection\Interfaces\EntityManagerInterface;

class CarService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CarRepository
     */
    private $carRepository;

    public function __construct(CarRepository $carRepository, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->carRepository = $carRepository;
    }

    /**
     * @return Car[]
     */
    public function getCars(): array
    {
        return $this->carRepository->getAll();
    }
}