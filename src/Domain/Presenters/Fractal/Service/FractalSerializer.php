<?php

namespace Domain\Presenters\Fractal\Service;

use League\Fractal\Serializer\ArraySerializer;

class FractalSerializer extends ArraySerializer
{

    /**
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return $data;
    }

    /**
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return $data;
    }

}