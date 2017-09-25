<?php

namespace Application\Providers;

use Infrastructure\ServiceProvider\AbstractServiceProvider;

class PresentersServiceProvider extends AbstractServiceProvider
{

    protected $provides = [
        \Domain\Presenters\Fractal\Service\FractalService::class
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(\Domain\Presenters\Fractal\Service\FractalService::class, function () use ($container) {
            return new \Domain\Presenters\Fractal\Service\FractalService(
                new \Domain\Presenters\Fractal\Service\FractalSerializer()
            );
        });

        parent::register();
    }
}