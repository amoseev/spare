<?php

namespace Infrastructure\Cache;

use Infrastructure\Cache\Interfaces\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;

class MemcachedTagAdapter extends TagAwareAdapter implements CacheItemPoolInterface
{
    const TAGS_PREFIX = "0tags0"; //memcached not work with default "\n" symbol
}