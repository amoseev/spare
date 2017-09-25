<?php


namespace Infrastructure\Events\Interfaces;

interface EventDispatcherInterface extends \Symfony\Component\EventDispatcher\EventDispatcherInterface
{
    public function fire(EventInterface $event);

    public function addSubscriberLazy($subscriberClass);

    public function addListenerLazy($eventName, $listenerClass, $method, $priority = 0);
}