<?php

namespace Infrastructure\Exception\Http;

use Infrastructure\Http\ResponseCode;

class ConflictHttpException extends HttpException
{
    /**
     * @var int
     */
    protected $statusCode = ResponseCode::HTTP_CONFLICT;

}