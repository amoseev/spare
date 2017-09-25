<?php

namespace Infrastructure\Events\Interfaces;

interface EventInterface
{
    public static function name(): string;

    /**
     * @link https://github.com/php-fig/fig-standards/blob/master/proposed/event-manager.md
     * Get target/context from which event was triggered
     *
     * @return null|string|object
     */
    public function getTarget();
}