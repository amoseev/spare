<?php

namespace Infrastructure\Events\Interfaces;

use Infrastructure\Container\Interfaces\ContainerAwareInterface;
use Infrastructure\Container\Traits\ContainerAwareTrait;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyEventDispatcher;

class EventDispatcher extends SymfonyEventDispatcher implements EventDispatcherInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function fire(EventInterface $event)
    {
        $this->dispatch($event::name(), $event);
    }

    /**
     * @param string $subscriberClass EventSubscriberInterface::class
     */
    public function addSubscriberLazy($subscriberClass)
    {
        /** @see  EventSubscriberInterface::getSubscribedEvents */
        foreach ($subscriberClass::getSubscribedEvents() as $eventName => $params) {
            if (is_string($params)) {
                $this->addListenerLazy($eventName, $subscriberClass, $params);
            } elseif (is_string($params[0])) {
                $method = $params[0];
                $priority = $params[1] ?? 0;
                $this->addListenerLazy($eventName, $subscriberClass, $method, $priority);
            } else {
                foreach ($params as $listener) {
                    $method = $listener[0];
                    $priority = $listener[1] ?? 0;
                    $this->addListenerLazy($eventName, $subscriberClass, $method, $priority);
                }
            }
        }
    }

    public function addListenerLazy($eventName, $listenerClass, $method, $priority = 0)
    {
        $this->addListener($eventName, function (EventInterface $event) use ($listenerClass, $method) {
            $subscriber = $this->getContainer()->get($listenerClass);
            $subscriber->$method($event);
        }, $priority);
    }
}