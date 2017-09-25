<?php

namespace Infrastructure\Exception\Http;

use Application\Exceptions\ApplicationException;
use Infrastructure\Http\ResponseCode;
use Infrastructure\MessageBag\Interfaces\MessageBagInterface;
use Infrastructure\MessageBag\MessageBag;
use Infrastructure\Exception\HasUserMessageException;
use Infrastructure\Exception\Interfaces\HasHttpStatusCodeExceptionInterface;
use Infrastructure\Exception\Interfaces\HasLocalizedErrorMessageExceptionInterface;
use Infrastructure\Exception\Interfaces\HasMessageBagExceptionInterface;

class HttpException extends HasUserMessageException implements HasLocalizedErrorMessageExceptionInterface, HasHttpStatusCodeExceptionInterface, HasMessageBagExceptionInterface
{
    /**
     * @var MessageBagInterface
     */
    protected $messageBag;

    /**
     * @var int
     */
    protected $statusCode = ResponseCode::HTTP_BAD_REQUEST;

    /**
     * @return int
     */
    public function getHttpStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return MessageBagInterface
     */
    public function getMessageBag()
    {
        return $this->messageBag ?: new MessageBag();
    }

    /**
     * @param MessageBagInterface $messageBag
     * @return $this
     */
    public function setMessageBag(MessageBagInterface $messageBag)
    {
        $this->messageBag = $messageBag;

        return $this;
    }

    /**
     * @param int $statusCode
     * @return HttpException
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = (int) $statusCode;

        return $this;
    }


    /**
     * @param MessageBagInterface $messageBag
     * @param string $translatedMessage
     * @return HttpException
     */
    public static function createWithMessageBag(MessageBagInterface $messageBag, string $translatedMessage = '')
    {
        $exception = (new static);
        $exception->setMessageBag($messageBag);
        if ($translatedMessage) {
            $exception->setTranslatedMessage($translatedMessage);
        }

        return $exception;
    }
}