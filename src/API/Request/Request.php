<?php

declare(strict_types=1);

namespace Ivolosevich\ExampleApiClient\API\Request;

use Ivolosevich\ExampleApiClient\API\Exception\ConfigException;

/**
 * Class Request
 * @package Ivolosevich\ExampleApiClient\API\Request
 */
class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    /**
     * @var string
     */
    private $method;
    /**
     * @var string
     */
    private $url = '';
    /**
     * @var string
     */
    private $path = '';

    /**
     * Request constructor.
     * @param string $method
     * @param string $path
     * @throws ConfigException
     */
    public function __construct(string $method, string $path)
    {
        if (!in_array($method, [self::METHOD_GET, self::METHOD_POST, self::METHOD_PUT, self::METHOD_DELETE], true) || $path === '') {
            throw new ConfigException('Either method or url is incorrect');
        }

        $this->method = $method;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Request
     */
    public function setUrl(string $url): Request
    {
        $this->url = $url;
        return $this;
    }
}
