<?php

namespace Infrastructure\Exception\Http;

use Infrastructure\Http\ResponseCode;

class NotFoundHttpException extends HttpException
{
    /**
     * @var int
     */
    protected $statusCode = ResponseCode::HTTP_NOT_FOUND;

}