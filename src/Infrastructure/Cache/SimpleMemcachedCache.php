<?php

namespace Infrastructure\Cache;

use Infrastructure\Cache\Interfaces\SimpleCacheInterface;
use Symfony\Component\Cache\Simple\MemcachedCache;

class SimpleMemcachedCache extends MemcachedCache implements SimpleCacheInterface
{

}