<?php

namespace Infrastructure\Exception;

use Infrastructure\Exception\Interfaces\HasLocalizedErrorMessageExceptionInterface;

/**
 * Допускается выводить пользователю сообщение ошибки
 */
class HasUserMessageException extends \Exception implements HasLocalizedErrorMessageExceptionInterface
{
    /**
     * @var string
     */
    protected $translatedMessage;

    /**
     * @return string
     */
    public function getTranslatedMessage(): string
    {
        if (empty($this->translatedMessage)) {
            return trans('Произошла ошибка');
        }
        return (string) $this->translatedMessage;
    }

    /**
     * @param $translatedMessage
     * @return static
     */
    public function setTranslatedMessage($translatedMessage)
    {
        $this->translatedMessage = $translatedMessage;

        return $this;
    }


    /**
     * @param string $translatedMessage Сообщение, для перевода пользователю
     * @param string $exceptionMessage Сообщение для разработчиков
     * @return static
     */
    public static function createWithUserMessage(string $translatedMessage, $exceptionMessage = '')
    {
        return (new static($exceptionMessage))->setTranslatedMessage($translatedMessage);
    }
}