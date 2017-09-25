<?php

namespace Application\Service\Routing;

use Infrastructure\Http\Interfaces\RequestInterface;
use Slim\Interfaces\RouterInterface;

class UrlGenerator
{

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var array
     */
    private $globalQueryParams = [];

    public function __construct(RouterInterface $router, RequestInterface $request)
    {
        $this->router = $router;
        $this->request = $request;
        $this->applyQueryParams();
    }

    /**
     * Все глобальные параметры в query_string могут быть применены для генерации роутов (доступ по токену)
     */
    private function applyQueryParams()
    {
        // $queryParams = $this->request->getQueryParams();
    }

    /**
     * Build the path for a named route including the base path
     *
     * @param string $name Route name
     * @param array $data Named argument replacement data
     * @param array $queryParams Optional query string parameters
     *
     * @return string
     *
     * @throws \RuntimeException         If named route does not exist
     * @throws \InvalidArgumentException If required data not provided
     */
    public function route($name, array $data = [], array $queryParams = []): string
    {
        return $this->router->pathFor($name,  $data, array_merge($queryParams, $this->globalQueryParams));
    }
}