<?php

namespace Infrastructure\Http\Request;

class ServerRequestFactory extends \Zend\Diactoros\ServerRequestFactory
{
    /**
     * @param array|null $server
     * @param array|null $query
     * @param array|null $body
     * @param array|null $cookies
     * @param array|null $files
     * @return ServerRequest
     */
    public static function fromGlobals(
        array $server = null,
        array $query = null,
        array $body = null,
        array $cookies = null,
        array $files = null
    ) {
        $server  = static::normalizeServer($server ?: $_SERVER);
        $files   = static::normalizeFiles($files ?: $_FILES);
        $headers = static::marshalHeaders($server);

        return new ServerRequest(
            $server,
            $files,
            static::marshalUriFromServer($server, $headers),
            static::get('REQUEST_METHOD', $server, 'GET'),
            'php://input',
            $headers,
            $cookies ?: $_COOKIE,
            $query ?: $_GET,
            $body ?: $_POST,
            static::marshalProtocolVersion($server)
        );
    }

    /**
     * Return HTTP protocol version (X.Y)
     *
     * @param array $server
     * @return string
     */
    private static function marshalProtocolVersion(array $server)
    {
        if (! isset($server['SERVER_PROTOCOL'])) {
            return '1.1';
        }

        if (! preg_match('#^(HTTP/)?(?P<version>[1-9]\d*(?:\.\d)?)$#', $server['SERVER_PROTOCOL'], $matches)) {
            return '1.1';
        }

        return $matches['version'];
    }
}