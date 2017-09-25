<?php

namespace Infrastructure\Http\Response;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;

class ResponseFactory
{
    protected static $accessControlHeaders = [
        'Access-Control-Allow-Origin'   => '*',
        'Access-Control-Allow-Methods'  => 'GET, POST, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers'  => 'X-Requested-With, Authorization, Content-Type',
        'Access-Control-Expose-Headers' => 'X-User_token, User_token',
        'P3P'                           => 'CP="ALL ADM DEV PSAi COM OUR OTRo STP IND ONL"',
    ];

    /**
     * @param mixed $data
     * @param array $meta
     * @param int $status
     * @param array $headers
     * @return ResponseInterface|JsonResponse
     * @throws \InvalidArgumentException
     */
    public function json($data, array $meta = [], int $status = 200, array $headers = []): ResponseInterface
    {
        return $this->jsonResponse($this->isSuccessStatus($status), $data, $meta, $status, $headers);
    }

    /**
     * @param bool $success
     * @param mixed $data
     * @param array $meta
     * @param int $status
     * @param array $headers
     * @return ResponseInterface|JsonResponse
     * @throws \InvalidArgumentException
     */
    protected function jsonResponse(bool $success,
                                    $data = null,
                                    array $meta = [],
                                    int $status = 200,
                                    array $headers = []): ResponseInterface
    {
        $data = [
            'success' => (bool) $success,
            'data'    => $data,
            'meta'    => $meta,
        ];

        return new JsonResponse($data, $status, array_merge(self::$accessControlHeaders, $headers));
    }

    /**
     * @param mixed $data
     * @param array $meta
     * @param int $status
     * @param array $headers
     * @return ResponseInterface|JsonResponse
     * @throws \InvalidArgumentException
     */
    public function jsonSuccess($data = null, array $meta = [], int $status = 200, array $headers = []): ResponseInterface
    {
        return $this->jsonResponse(true, $data, $meta, $status, $headers);
    }

    /**
     * @param mixed $data
     * @param array $meta
     * @param int $status
     * @param array $headers
     * @return ResponseInterface|JsonResponse
     * @throws \InvalidArgumentException
     */
    public function jsonError($data = null, array $meta = [], int $status = 500, array $headers = []): ResponseInterface
    {
        return $this->jsonResponse(false, $data, $meta, $status, $headers);
    }

    /**
     * @param string $message Будет показано пользователю в админке
     * @param int $status
     * @param array $headers
     * @return ResponseInterface|JsonResponse
     * @throws \InvalidArgumentException
     */
    public function jsonErrorMessage($message, int $status = 500, array $headers = []): ResponseInterface
    {
        return $this->jsonResponse(false, null, [
            'message' => $message,
        ], $status, $headers);
    }

    /**
     * @param       $message
     * @param int $status
     * @param array $headers
     * @return ResponseInterface
     * @throws \InvalidArgumentException
     */
    public function jsonSuccessMessage(string $message, int $status = 200, array $headers = []): ResponseInterface
    {
        return $this->jsonResponse(true, null, [
            'message' => $message,
        ], $status, $headers);
    }

    /**
     * @param $uri
     * @param int $status
     * @param array $headers
     * @return ResponseInterface
     */
    public function redirect($uri, $status = 302, array $headers = []): ResponseInterface
    {
        return new RedirectResponse($uri, $status, $headers);
    }

    /**
     * @param $body
     * @param int $status
     * @param array $headers
     * @return ResponseInterface|HtmlResponse
     * @throws \InvalidArgumentException
     */
    public function html($body, $status = 200, array $headers = []): ResponseInterface
    {
        return new HtmlResponse($body, $status, $headers);
    }

    /**
     * @param $statusCode
     * @return bool
     */
    protected function isSuccessStatus($statusCode): bool
    {
        return strpos((string) $statusCode, '2') === 0;
    }

    /**
     * @param string|resource|\Psr\Http\Message\StreamInterface $body Stream identifier and/or actual stream resource
     * @param int $status Status code for the response, if any.
     * @param array $headers Headers for the response, if any.
     * @return ResponseInterface
     * @throws \InvalidArgumentException on any invalid element.
     */
    public function response($body = 'php://memory', $status = 200, array $headers = []): ResponseInterface
    {
        return new Response($body, $status, $headers);
    }

    /**
     * @param int $status
     * @return ResponseInterface
     */
    public function emptyResponse(int $status = 200): ResponseInterface
    {
        return new Response\EmptyResponse($status, self::$accessControlHeaders);
    }

    /**
     * @param string $xml
     * @param int $status
     * @param array $headers
     * @return ResponseInterface
     */
    public function xml(string $xml, int $status = 200, array $headers = []): ResponseInterface
    {
        return new XmlResponse($xml, $status, $headers);
    }
}