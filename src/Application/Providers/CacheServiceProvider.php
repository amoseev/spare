<?php

namespace Application\Providers;

use Infrastructure\Cache\Interfaces\CacheItemPoolInterface;
use Infrastructure\Cache\Interfaces\SimpleCacheInterface;
use Infrastructure\Cache\MemcachedTagAdapter;
use Infrastructure\Cache\SimpleMemcachedCache;
use Infrastructure\ServiceProvider\AbstractServiceProvider;

class CacheServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        CacheItemPoolInterface::class,
        SimpleCacheInterface::class,
    ];

    public function register()
    {
        $container = $this->getContainer();


        $container->share(CacheItemPoolInterface::class, function () use ($container) {
            return \Symfony\Component\Cache\Adapter\MemcachedAdapter::createConnection(array(array('localhost', 11211)));
        });


        $container->share(SimpleCacheInterface::class, function () use ($container) {
            return SimpleMemcachedCache::createConnection(array(array('localhost', 11211)));
        });

        parent::register();
    }
}