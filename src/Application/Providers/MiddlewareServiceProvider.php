<?php

namespace Application\Providers;

use Application\Error\WebErrorHandler;
use Infrastructure\ServiceProvider\AbstractServiceProvider;

class MiddlewareServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        \Application\Http\Middleware\Web\WebHandleExceptionMiddleware::class,
    ];

    public function register()
    {
        $container = $this->getContainer();


        $container->share(\Application\Http\Middleware\Web\WebHandleExceptionMiddleware::class, function () use ($container) {
            return new \Application\Http\Middleware\Web\WebHandleExceptionMiddleware(
                $container->get(WebErrorHandler::class),
                isDevEnv()
            );
        });

        parent::register();
    }


}