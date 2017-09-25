<?php

namespace Application\Http\Middleware;

use FastRoute\Dispatcher;
use Infrastructure\Http\Interfaces\RequestInterface;
use Infrastructure\Exception\Http\BadRequestHttpException;
use Psr\Http\Message\ResponseInterface;

class JsonRequestInterceptorMiddleware
{
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param \Callable $next
     * @return mixed
     * @throws \InvalidArgumentException
     * @throws \Infrastructure\Exception\Http\HttpException
     */
    public function __invoke($request, $response, $next)
    {
        if (! $request->getParsedBody() && $request->getBody() && $request->isJsonMediaType()) {
            $rawBody = (string) $request->getBody();
            $parsedBody = json_decode($rawBody, true);

            if ((null === $parsedBody) && $rawBody) {
                throw BadRequestHttpException::createWithUserMessage(trans('Некорректный формат запроса'));
            }

            $request = $request->withParsedBody($parsedBody);
        }

        return $next($request, $response);
    }
}