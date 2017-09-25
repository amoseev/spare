<?php

namespace Infrastructure\Container;

class ReflectionContainer extends \League\Container\ReflectionContainer
{
    protected $instances = [];

    /**
     * По умолчанию создаю shared сервисы
     * {@inheritdoc}
     */
    public function get($alias, array $args = [])
    {
        $key = md5(serialize([$alias, $args]));
        if (!isset($this->instances[$key])) {
            $this->instances[$key] = parent::get($alias, $args);
        }

        return $this->instances[$key];
    }
}