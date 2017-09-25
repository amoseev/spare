<?php

namespace Application\Service\Error;

use Doctrine\ORM\EntityNotFoundException;
use Infrastructure\Http\ResponseCode;
use Infrastructure\Exception\Interfaces\HasHttpStatusCodeExceptionInterface;
use Infrastructure\Exception\Interfaces\HasLocalizedErrorMessageExceptionInterface;

class HttpExceptionService
{
    const DEFAULT_HTTP_ERROR_STATUS_CODE = ResponseCode::HTTP_INTERNAL_SERVER_ERROR;

    protected $httpStatusMap = [
        EntityNotFoundException::class    => ResponseCode::HTTP_NOT_FOUND,
        \InvalidArgumentException::class  => ResponseCode::HTTP_UNPROCESSABLE_ENTITY,
    ];

    /**
     * @param \Throwable $exception
     * @return int
     */
    public function getHttpStatusCodeByException(\Throwable $exception)
    {
        if ($exception instanceof HasHttpStatusCodeExceptionInterface) {
            return $exception->getHttpStatusCode();
        }

        $exceptionClassName = get_class($exception);
        if (isset($this->httpStatusMap[$exceptionClassName])) {
            return $this->httpStatusMap[$exceptionClassName];
        }

        if ($exception instanceof HasLocalizedErrorMessageExceptionInterface) {
            return ResponseCode::HTTP_BAD_REQUEST;
        }

        return self::DEFAULT_HTTP_ERROR_STATUS_CODE;
    }
}