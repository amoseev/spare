<?php

namespace Infrastructure\Exception\Http;

use Infrastructure\Http\ResponseCode;

class UnprocessableEntityHttpException extends HttpException
{
    /**
     * @var int
     */
    protected $statusCode = ResponseCode::HTTP_UNPROCESSABLE_ENTITY;

}