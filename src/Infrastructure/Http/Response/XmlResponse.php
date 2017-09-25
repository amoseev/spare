<?php


namespace Application\Http\Response;


use Zend\Diactoros\Response;
use Zend\Diactoros\Response\InjectContentTypeTrait;
use Zend\Diactoros\Stream;

class XmlResponse extends Response
{
    use InjectContentTypeTrait;

    public function __construct(
        $data,
        $status = 200,
        array $headers = []
    )
    {
        $body = new Stream('php://temp', 'wb+');
        $body->write($data);
        $body->rewind();

        $headers = $this->injectContentType('application/xml', $headers);

        parent::__construct($body, $status, $headers);
    }

}