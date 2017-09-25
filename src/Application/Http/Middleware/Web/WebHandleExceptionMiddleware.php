<?php

namespace Application\Http\Middleware\Web;

use Application\Error\ApiErrorHandler;
use Application\Error\WebErrorHandler;
use Psr\Http\Message\ResponseInterface;

class WebHandleExceptionMiddleware
{
    /**
     * @var WebErrorHandler
     */
    private $webHandler;

    /**
     * @var bool
     */
    protected $isDebug;

    public function __construct(WebErrorHandler $webHandler, bool $isDebug)
    {
        $this->webHandler = $webHandler;
        $this->isDebug = $isDebug;
    }

    /**
     * Example middleware invokable class
     *
     * @param  \Infrastructure\Http\Interfaces\RequestInterface $request PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface $response PSR7 response
     * @param  callable $next Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next): ResponseInterface
    {
        try {
            return $next($request, $response);
        } catch (\Throwable $e) {
            return $this->webHandler->handle($request, $response, $e, $this->isDebug);
        }
    }
}