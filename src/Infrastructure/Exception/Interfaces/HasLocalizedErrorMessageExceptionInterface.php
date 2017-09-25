<?php

namespace Infrastructure\Exception\Interfaces;

interface HasLocalizedErrorMessageExceptionInterface
{
    public function getTranslatedMessage(): string;
}