<?php

namespace Infrastructure\Cache\Interfaces;

use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;

interface CacheItemPoolInterface extends TagAwareAdapterInterface
{

}