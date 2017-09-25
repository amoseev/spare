<?php

namespace Infrastructure\Http\Interfaces;

use Infrastructure\DateTime\DateTimeFormat;
use Psr\Http\Message\ServerRequestInterface;

interface RequestInterface extends ServerRequestInterface
{
    /**
     * @return bool
     */
    public function isJsonMediaType();

    /**
     * Is this an XHR request?
     *
     * Note: This method is not part of the PSR-7 standard.
     *
     * @return bool
     */
    public function isXhr();

    /**
     * @param string $key
     * @return bool
     */
    public function hasParam(string $key);

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
    public function getParam(string $key, $default = null);

    /**
     * Retrieve a server parameter.
     *
     * Note: This method is not part of the PSR-7 standard.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function getServerParam(string $key, $default = null);

    /**
     * @param string $key
     * @param array $default
     * @return array
     */
    public function getArrayParam(string $key, array $default = []): array;

    /**
     * @param string $key
     * @param null $default
     * @return int|null
     */
    public function getIntParam(string $key, $default = null);

    /**
     * @param string $key
     * @param null $default
     * @return float|null
     */
    public function getFloatParam(string $key, $default = null);

    /**
     * @param string $key
     * @param null $default
     * @return bool|null
     */
    public function getBoolParam(string $key, $default = null);

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function getPriceParam(string $key, $default = null);

    /**
     * @param string $key
     * @param null $default
     * @param string $charList
     * @return null|string
     */
    public function getStringParam(string $key, $default = null, $charList = " \t\n\r\0\x0B");

    /**
     * @param string $key
     * @param null|string|\DateTime $default
     * @param string $dateFormat
     * @return null|string
     */
    public function getDateParam(string $key, $default = null, $dateFormat = DateTimeFormat::DATE_HUMAN);

    /**
     * @param string $key
     * @param null|string|\DateTime $default
     * @param string $dateFormat
     * @return null|string
     */
    public function getDateTimeParam(string $key, $default = null, $dateFormat = DateTimeFormat::DATE_TIME_HUMAN);

    /**
     * @param string $key
     * @param \DateTime|null $default
     * @param string $dateFormat
     * @return \DateTime|null
     */
    public function getDateTimeInstanceParam(string $key, \DateTime $default = null, $dateFormat = DateTimeFormat::DATE_HUMAN);

    /**
     * @return string
     */
    public function getIp(): string;

    /**
     * @return array
     */
    public function getParams(): array;

}