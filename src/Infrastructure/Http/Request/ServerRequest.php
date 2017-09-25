<?php

namespace Infrastructure\Http\Request;

use Infrastructure\DateTime\DateTimeFormat;
use Infrastructure\Http\Interfaces\RequestInterface;
use Zend\Diactoros\ServerRequest as BaseServerRequest;

class ServerRequest extends BaseServerRequest implements RequestInterface
{
    /**
     * @return bool
     */
    public function isJsonMediaType()
    {
        return strpos($this->getHeaderLine('Content-Type'), 'application/json') !== false;
    }

    /**
     * Is this an XHR request?
     *
     * Note: This method is not part of the PSR-7 standard.
     *
     * @return bool
     */
    public function isXhr()
    {
        return $this->getHeaderLine('X-Requested-With') === 'XMLHttpRequest';
    }

    /**
     * Fetch request parameter value from body or query string (in that order).
     *
     * Note: This method is not part of the PSR-7 standard.
     *
     * @param  string $key The parameter key.
     * @param  string $default The default value.
     *
     * @return mixed The parameter value.
     */
    public function getParam(string $key, $default = null)
    {
        $postParams = $this->getParsedBody();
        $getParams = $this->getQueryParams();
        $result = $default;
        if (is_array($postParams) && isset($postParams[$key])) {
            $result = $postParams[$key];
        } elseif (is_object($postParams) && property_exists($postParams, $key)) {
            $result = $postParams->$key;
        } elseif (isset($getParams[$key])) {
            $result = $getParams[$key];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return array_merge($this->getQueryParams(), (array) $this->getParsedBody());
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasParam(string $key)
    {
        $postParams = $this->getParsedBody();
        $getParams = $this->getQueryParams();

        if (is_array($postParams) && isset($postParams[$key])) {
            return true;
        } elseif (is_object($postParams) && property_exists($postParams, $key)) {
            return true;
        } elseif (isset($getParams[$key])) {
            return true;
        }

        return false;
    }

    /**
     * Fetch cookie value from cookies sent by the client to the server.
     *
     * Note: This method is not part of the PSR-7 standard.
     *
     * @param string $key The attribute name.
     * @param mixed $default Default value to return if the attribute does not exist.
     *
     * @return mixed
     */
    public function getCookieParam(string $key, $default = null)
    {
        $cookies = $this->getCookieParams();
        $result = $default;
        if (isset($cookies[$key])) {
            $result = $cookies[$key];
        }

        return $result;
    }

    /**
     * Retrieve a server parameter.
     *
     * Note: This method is not part of the PSR-7 standard.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function getServerParam(string $key, $default = null)
    {
        $serverParams = $this->getServerParams();

        return $serverParams[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param array $default
     * @return array
     */
    public function getArrayParam(string $key, array $default = []): array
    {
        return (array) $this->getParam($key, $default);
    }

    /**
     * @param string $key
     * @param null $default
     * @return int|null
     */
    public function getIntParam(string $key, $default = null)
    {
        return $this->hasParam($key) ? (int) $this->getParam($key) : $default;
    }

    /**
     * @param string $key
     * @param null $default
     * @return float|null
     */
    public function getFloatParam(string $key, $default = null)
    {
        return $this->hasParam($key) ? (float) $this->getParam($key) : $default;
    }

    /**
     * @param string $key
     * @param null $default
     * @return float|null
     */
    public function getPriceParam(string $key, $default = null)
    {
        return $this->hasParam($key) ? round((float) str_replace(',', '.', $this->getParam($key)), 2) : $default;
    }

    /**
     * @param string $key
     * @param null $default
     * @return bool|null
     */
    public function getBoolParam(string $key, $default = null)
    {
        return $this->hasParam($key) ? (bool) $this->getParam($key) : $default;
    }

    /**
     * @param string $key
     * @param null $default
     * @param string $charList
     * @return null|string
     */
    public function getStringParam(string $key, $default = null, $charList = " \t\n\r\0\x0B")
    {
        return $this->hasParam($key) ? trim((string) $this->getParam($key, $default), $charList) : $default;
    }

    /**
     * @param string $key
     * @param null|string|\DateTime $default
     * @param string $dateFormat
     * @return null|string
     */
    public function getDateParam(string $key, $default = null, $dateFormat = DateTimeFormat::DATE_HUMAN)
    {
        if ($this->hasParam($key)) {
            $date = $this->getParam($key);

            $date = \DateTime::createFromFormat($dateFormat, $date);
            if ($date instanceof \DateTime) {
                return $date->format($dateFormat);
            }
        }

        if ($default instanceof \DateTime) {
            return $default->format($dateFormat);
        }

        return $default;
    }

    /**
     * @param string $key
     * @param null|string|\DateTime $default
     * @param string $dateFormat
     * @return null|string
     */
    public function getDateTimeParam(string $key, $default = null, $dateFormat = DateTimeFormat::DATE_TIME_HUMAN)
    {
        return $this->getDateParam($key, $default, $dateFormat);
    }

    /**
     * @param string $key
     * @param \DateTime|null $default
     * @param string $dateFormat
     * @return \DateTime|null
     */
    public function getDateTimeInstanceParam(string $key, \DateTime $default = null, $dateFormat = DateTimeFormat::DATE_HUMAN)
    {
        if ($this->hasParam($key)) {
            $date = $this->getParam($key);

            $date = \DateTime::createFromFormat($dateFormat, $date);
            if ($date instanceof \DateTime) {
                return $date;
            }
        }

        return $default;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->getServerParam('HTTP_X_REAL_IP');
    }
}