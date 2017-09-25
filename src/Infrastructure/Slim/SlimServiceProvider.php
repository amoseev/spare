<?php

namespace Infrastructure\Slim;

use Application\Error\WebErrorHandler;
use Infrastructure\Http\Request\ServerRequestFactory;
use Infrastructure\Http\Response\ResponseFactory;
use Infrastructure\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Infrastructure\Exception\Http\NotFoundHttpException;
use Slim\CallableResolver;
use Slim\Collection;
use Slim\Router;

class SlimServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    /**
     * @var array
     */
    protected $provides = [
        'settings',
        'callableResolver',
        'request',
        'response',
    ];

    /**
     * @var array
     */
    private $defaultSettings = [
        'httpVersion'                       => '1.1',
        'responseChunkSize'                 => 4096,
        'outputBuffering'                   => false,
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails'               => true,
    ];

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $container = $this->getContainer();

        $container->share('settings', function () {
            return new Collection($this->defaultSettings);
        });

        $container->share('callableResolver', function () {
            return new CallableResolver($this->getContainer());
        });

        $container->share('request', function () {
            return ServerRequestFactory::fromGlobals();
        });

        /**
         * При любой модификации запроса возвращается новый объект, а ссылка в контейнере остается на старом объекте запроса
         * По всему приложению запрос должен передаваться из сервиса в сервис
         **/

        $container->share('response', function () use ($container) {
            return $container->get(ResponseFactory::class)->response();
        });

        $container->share('foundHandler', function () use ($container) {
            return $container->get(InvocationControllerHandler::class);
        });

        $container->share('notFoundHandler', function () use ($container) {
            return function($request, $response) use ($container) {
                /** @var WebErrorHandler $webErrorHandler */
                $webErrorHandler = $container->get(WebErrorHandler::class);

                return $webErrorHandler->handle($request, $response, new NotFoundHttpException(), getenv('ENV_DEV'));
            };
        });

        $container->share('router', function () {
            $routerCacheFile = false;
            if (! isDevEnv()) {
                $routerCacheFile = self::getCacheFileName();
            }

            return (new Router)->setCacheFile($routerCacheFile);
        });
    }

    /**
     * @return string
     */
    private static function getCacheFileName()
    {
        return sys_get_temp_dir() . '/app-routing-cache-' . substr(md5(__FILE__), 0, 20) . '.cache';
    }
}