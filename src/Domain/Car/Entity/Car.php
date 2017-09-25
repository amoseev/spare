<?php

namespace Domain\Car\Entity;

use Doctrine\ORM\Mapping;

/**
 * @Entity(repositoryClass="\Domain\Car\Repository\CarRepository")
 * @Table(name="car")
 */
class Car
{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", length=64)
     */
    protected $model;

    public static function create(string $model)
    {
        $car = new Car;
        $car->model = $model;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }


}