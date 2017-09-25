<?php


namespace Application\Providers;

use Infrastructure\ServiceProvider\AbstractServiceProvider;
use Monolog\Logger;

class LoggerServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        \Psr\Log\LoggerInterface::class,
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(\Psr\Log\LoggerInterface::class, function () use ($container) {
            return new Logger('default');
        });

        parent::register();
    }
}