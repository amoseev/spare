<?php

namespace Infrastructure\Exception\Http;

use Infrastructure\Http\ResponseCode;

class AccessDeniedHttpException extends HttpException
{
    /**
     * @var int
     */
    protected $statusCode = ResponseCode::HTTP_FORBIDDEN;

    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->setTranslatedMessage(trans('Недостаточно прав'));
    }
}