<?php

namespace Infrastructure\Exception\Http;

use Exception;
use Infrastructure\Http\ResponseCode;

class BadRequestHttpException extends HttpException
{
    protected $statusCode = ResponseCode::HTTP_BAD_REQUEST;
}