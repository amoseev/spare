<?php

namespace Application\Error;

use Application\Service\Error\HttpExceptionService;
use Application\Service\Error\Whoops\WhoopsRunner;
use Infrastructure\Http\Response\ResponseFactory;
use Infrastructure\Http\ResponseCode;
use Psr\Http\Message\ResponseInterface as Response;
use Infrastructure\Http\Interfaces\RequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Handlers\AbstractHandler;

class WebErrorHandler extends AbstractHandler
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var HttpExceptionService
     */
    private $httpExceptionService;

    /**
     * Handler constructor.
     * @param LoggerInterface $logger
     * @param ResponseFactory $responseFactory
     * @param HttpExceptionService $httpExceptionService
     */
    public function __construct(LoggerInterface $logger,
                                ResponseFactory $responseFactory,
                                HttpExceptionService $httpExceptionService)
    {
        $this->logger = $logger;
        $this->responseFactory = $responseFactory;
        $this->httpExceptionService = $httpExceptionService;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param \Throwable $exception
     * @param bool $isDev
     * @return Response
     */
    public function handle(Request $request, Response $response, \Throwable $exception, bool $isDev): Response
    {
        if ($request->isXhr()) {
            $contentType = 'application/json';
        } else {
            $contentType = $this->determineContentType($request);
        }

        if ($exception instanceof \Infrastructure\Exception\Interfaces\HasLocalizedErrorMessageExceptionInterface) {
            $message = !empty($exception->getTranslatedMessage()) ? $exception->getTranslatedMessage() : trans('Произошла ошибка'); //покажем текст пользователю в админке
            $this->logger->debug($exception->getMessage(), [$exception]);
        } else {
            $message = trans('Произошла ошибка'); //покажем текст пользователю в админке
            $this->logger->error($exception->getMessage(), [$exception]);
        }

        switch ($contentType) {
            case 'application/json':
                $meta = [
                    'message' => $message,
                ];

                if ($isDev) {
                    $meta['exception_message'] = $exception->getMessage();
                    $meta['exception_trace'] = $exception->getTraceAsString();
                }

                return $this->responseFactory->jsonError(null, $meta, ResponseCode::HTTP_OK);
            case 'text/xml':
            case 'text/html':
            case 'application/xml':
            default:
                if ($isDev) {
                    return WhoopsRunner::handle($exception, $request);
                }
                $statusCode = $this->httpExceptionService->getHttpStatusCodeByException($exception);
                if ($statusCode == ResponseCode::HTTP_FORBIDDEN) {
                    return $this->responseFactory->html('Forbidden', ResponseCode::HTTP_FORBIDDEN);
                } else {
                    return $this->responseFactory->html('Not Found', ResponseCode::HTTP_NOT_FOUND);
                }
        }
    }
}