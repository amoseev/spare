<?php

namespace Application\Http\Controllers;

use Domain\Presenters\Fractal\Service\FractalService;
use Infrastructure\Container\Interfaces\ContainerAwareInterface;
use Infrastructure\Container\Traits\ContainerAwareTrait;
use Infrastructure\Http\Response\ResponseFactory;
use Infrastructure\Http\ResponseCode;
use League\Fractal\TransformerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

abstract class BaseController implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var ResponseFactory|null
     */
    private $responseFactory;

    final public function getResponseFactory(): ResponseFactory
    {
        if ($this->responseFactory) {
            return $this->responseFactory;
        }

        return $this->responseFactory = $this->getContainer()->get(ResponseFactory::class);
    }

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * @return LoggerInterface
     */
    final public function getLogger(): LoggerInterface
    {
        if ($this->logger) {
            return $this->logger;
        }

        return $this->logger = $this->getContainer()->get(LoggerInterface::class);
    }


    /**
     * @param $uri
     * @param int $status
     * @param array $headers
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function redirect($uri, $status = 302, array $headers = []): ResponseInterface
    {
        return $this->getResponseFactory()->redirect($uri, $status, $headers);
    }

    /**
     * @param $body
     * @param int $status
     * @param array $headers
     * @return ResponseInterface|HtmlResponse
     */
    protected function html($body, $status = 200, array $headers = []): ResponseInterface
    {
        return $this->getResponseFactory()->html($body, $status, $headers);
    }

    /**
     * @param mixed $data
     * @param array $meta
     * @param int $status
     * @param array $headers
     * @return ResponseInterface|JsonResponse
     */
    protected function json($data, $meta = [], $status = 200, $headers = []): ResponseInterface
    {
        return $this->getResponseFactory()->json($data, $meta, $status, $headers);
    }

    /**
     * @param array $meta
     * @param int $status
     * @param array $headers
     * @return ResponseInterface|JsonResponse
     * @throws \InvalidArgumentException
     */
    protected function jsonError(array $meta = [], int $status = ResponseCode::HTTP_BAD_REQUEST, array $headers = []): ResponseInterface
    {
        return $this->getResponseFactory()->jsonError(null, $meta, $status, $headers);
    }

    /**
     * @var FractalService
     */
    protected $fractalService;

    /**
     * @return FractalService
     */
    public function getFractalService(): FractalService
    {
        if (! $this->fractalService) {
            $this->fractalService = $this->getContainer()->get(FractalService::class);
        }

        return $this->fractalService;
    }

    /**
     * @param array $collection
     * @param TransformerAbstract $transformer
     * @param array $meta
     * @param int $status
     * @param array $headers
     * @return ResponseInterface|JsonResponse
     * @throws \InvalidArgumentException
     */
    protected function collection(array $collection,
                                  TransformerAbstract $transformer,
                                  array $meta = [],
                                  int $status = 200,
                                  array $headers = []): ResponseInterface
    {
        $data = $this->getFractalService()->collection($collection, $transformer)->toArray();

        if (! array_key_exists('count', $meta)) {
            $meta['count'] = count($collection);
        }

        return $this->getResponseFactory()->jsonSuccess($data, $meta, $status, $headers);
    }

    /**
     * @param $item
     * @param TransformerAbstract $transformer
     * @param int $status
     * @param array $headers
     * @return ResponseInterface|JsonResponse
     * @throws \InvalidArgumentException
     */
    protected function item($item,
                            TransformerAbstract $transformer,
                            int $status = 200,
                            array $headers = []): ResponseInterface
    {
        $data = $this->getFractalService()->item($item, $transformer)->toArray();

        return $this->getResponseFactory()->jsonSuccess($data, [], $status, $headers);
    }

    /**
     * @param string $message
     * @param int $status
     * @param array $headers
     * @return ResponseInterface
     */
    protected function created(string $message = 'Created', int $status = 201,  array $headers = []): ResponseInterface
    {
        return $this->getResponseFactory()->jsonSuccessMessage($message, $status, $headers);
    }

    /**
     * @param string $message
     * @param int $status
     * @param array $headers
     * @return ResponseInterface
     * @throws \InvalidArgumentException
     */
    protected function accepted($message = 'Accepted', $status = 202, array $headers = []): ResponseInterface
    {
        return $this->getResponseFactory()->jsonSuccessMessage($message, $status, $headers);
    }
}