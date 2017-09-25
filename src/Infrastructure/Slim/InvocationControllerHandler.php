<?php


namespace Infrastructure\Slim;

use Infrastructure\Container\Interfaces\ContainerAwareInterface;
use Infrastructure\Container\Traits\ContainerAwareTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\InvocationStrategyInterface;

class InvocationControllerHandler implements InvocationStrategyInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;


    /**
     * Invoke a route callable with request, response and all route parameters
     * as individual arguments.
     *
     * @param array|callable $callable
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $routeArguments
     *
     * @return mixed
     */
    public function __invoke(
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    )
    {

        // Inject the request and response by parameter name
        $parameters = [
            'request'  => $request,
            'response' => $response,
        ];
        // Inject the route arguments by name
        $parameters += $routeArguments;

        /**
         * @see https://github.com/PHP-DI/Slim-Bridge/blob/master/src/ControllerInvoker.php#L47
         */
        return $this->getContainer()->call($callable, $parameters);
    }
}