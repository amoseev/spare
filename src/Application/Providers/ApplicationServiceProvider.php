<?php

namespace Application\Providers;

use Infrastructure\Routing\RoutingServiceProvider;
use Infrastructure\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class ApplicationServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    const APP_ROOT_DIR_PATH = __DIR__ . '/../../../../'; // путь до корневой директории приложения

    public function registerApplication()
    {
        $container = $this->getContainer();
        //infrastructure
        $container->addServiceProvider(\Application\Providers\DbServiceProvider::class);
        $container->addServiceProvider(\Application\Providers\ImageServiceProvider::class);
        $container->addServiceProvider(\Application\Providers\LoggerServiceProvider::class);
        $container->addServiceProvider(\Application\Providers\MiddlewareServiceProvider::class);
        $container->addServiceProvider(\Application\Providers\CacheServiceProvider::class);

        $container->addServiceProvider(\Application\Providers\EventServiceProvider::class);
        $container->addServiceProvider(\Application\Providers\PresentersServiceProvider::class);
        $container->addServiceProvider(\Application\Providers\FileServiceProvider::class);
        $container->addServiceProvider(\Infrastructure\Routing\RoutingServiceProvider::class);

        //domain
        $container->addServiceProvider(\Domain\Car\ServiceProvider\CarServiceProvider::class);

    }

    public function boot()
    {
        $container = $this->getContainer();
        $container->addServiceProvider(\Infrastructure\Slim\SlimServiceProvider::class);


        $app = new \Slim\App($container);
        $container->share('app', $app);

        //routing New controllers
        require RoutingServiceProvider::ROUTE_FILE;

        $this->loadConfig();
        $this->registerApplication();
    }

    public function loadConfig()
    {
        date_default_timezone_set(getenv('TIMEZONE'));

        mb_internal_encoding('UTF-8');
    }
}