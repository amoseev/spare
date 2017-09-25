<?php

namespace Application\Providers;

use Infrastructure\Events\Interfaces\EventDispatcher;
use Infrastructure\Events\Interfaces\EventDispatcherInterface;
use Infrastructure\ServiceProvider\AbstractServiceProvider;

class EventServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        EventDispatcherInterface::class,
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(EventDispatcherInterface::class, function () use ($container) {
            return $container->get(EventDispatcher::class);
        });
        $this->registerSubscribers();

        parent::register();
    }

    public function registerSubscribers()
    {
        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $this->getContainer()->get(EventDispatcherInterface::class);

        //$eventDispatcher->addSubscriberLazy(EntityImageChangesSubscriber::class);
    }

}
