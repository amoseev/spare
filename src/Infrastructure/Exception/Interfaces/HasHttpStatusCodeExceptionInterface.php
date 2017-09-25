<?php

namespace Infrastructure\Exception\Interfaces;

interface HasHttpStatusCodeExceptionInterface
{
    /**
     * @return int
     */
    public function getHttpStatusCode(): int;
}