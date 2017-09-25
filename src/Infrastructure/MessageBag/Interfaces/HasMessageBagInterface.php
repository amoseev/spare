<?php

namespace Infrastructure\MessageBag\Interfaces;

interface HasMessageBagInterface
{
    /**
     * @return MessageBagInterface
     */
    public function getMessageBag();
}