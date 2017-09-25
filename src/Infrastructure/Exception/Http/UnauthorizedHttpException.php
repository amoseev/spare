<?php

namespace Infrastructure\Exception\Http;

use Infrastructure\Http\ResponseCode;

class UnauthorizedHttpException extends HttpException
{
    /**
     * @var int
     */
    protected $statusCode = ResponseCode::HTTP_UNAUTHORIZED;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->setTranslatedMessage(trans('Необходима авторизация'));
    }

}