<?php

namespace Application\Http\Controllers\Car;

use Application\Http\Controllers\BaseController;
use Domain\Car\Service\CarService;
use Domain\Car\Transformer\CarTransformer;
use Infrastructure\Http\Interfaces\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CarController extends BaseController
{
    /**
     * @var CarService
     */
    private $carService;

    /**
     * @var CarTransformer
     */
    private $carTransformer;

    public function __construct(CarService $carService, CarTransformer $carTransformer)
    {
        $this->carService = $carService;
        $this->carTransformer = $carTransformer;
    }

    public function __invoke(RequestInterface $request): ResponseInterface
    {
        $cars = $this->carService->getCars();

        return $this->collection($cars, $this->carTransformer);
    }
}