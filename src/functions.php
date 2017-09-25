<?php

function container(): \Infrastructure\Container\Interfaces\ContainerInterface
{
    return \Infrastructure\Container\ContainerFactory::getInstance();
}

function trans(string $message): string
{
    return $message;
}

function isDevEnv(): bool
{
    return strtolower(getenv('ENV')) === 'dev';
}