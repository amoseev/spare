<?php

namespace Domain\Car\Repository;

use Domain\Car\Entity\Car;
use Infrastructure\DatabaseConnection\AbstractEntityRepository;

class CarRepository extends AbstractEntityRepository
{
    /**
     * @return Car[]
     */
    public function getAll(): array
    {
        return $this->findAll();
    }
}