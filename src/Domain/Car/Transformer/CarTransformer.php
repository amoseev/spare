<?php

namespace Domain\Car\Transformer;

use Domain\Car\Entity\Car;
use League\Fractal\TransformerAbstract;

class CarTransformer extends TransformerAbstract
{
    /**
     * @param Car $car
     * @return array
     */
    public function transform(Car $car): array
    {
        return [
            'id'    => $car->getId(),
            'model' => $car->getModel(),
        ];
    }
}