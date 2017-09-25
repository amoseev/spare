<?php

namespace Domain\Presenters\Fractal\Service;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Scope;
use League\Fractal\ScopeFactoryInterface;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;

class FractalService extends Manager
{
    /**
     * FractalService constructor.
     */
    public function __construct(SerializerAbstract $serializerAbstract, ScopeFactoryInterface $scopeFactory = null)
    {
        $this->setSerializer($serializerAbstract);
        parent::__construct($scopeFactory);
    }

    /**
     * @param mixed $item
     * @param TransformerAbstract $transformerAbstract
     * @return Scope
     */
    public function item($item, TransformerAbstract $transformerAbstract)
    {
        return $this->createData(new Item($item, $transformerAbstract));
    }

    /**
     * @param array $data
     * @param TransformerAbstract $transformerAbstract
     * @return Scope
     */
    public  function collection(array $data, TransformerAbstract $transformerAbstract)
    {
        return $this->createData(new Collection($data, $transformerAbstract));
    }
}