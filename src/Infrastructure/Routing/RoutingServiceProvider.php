<?php


namespace Infrastructure\Routing;

use Application\Service\Routing\UrlGenerator;
use Infrastructure\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;


class RoutingServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{

    const ROUTE_FILE = __DIR__ . '/../../Application/Http/Routing/routing.php';

    /**
     * @var array
     */
    protected $provides = [
        UrlGenerator::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $container = $this->getContainer();

        $container->share(UrlGenerator::class, function () use ($container) {
            return new UrlGenerator(
                $container->get('router'),
                $container->get('request')
            );
        });
    }

}