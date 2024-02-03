<?php

declare(strict_types=1);

namespace Ivolosevich\ExampleApiClient\API;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Ivolosevich\ExampleApiClient\API\Exception\BadRequestException;
use Ivolosevich\ExampleApiClient\API\Exception\NotFoundException;
use Ivolosevich\ExampleApiClient\API\Exception\RemoteServiceException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractApi
 * @package Ivolosevich\ExampleApiClient\API
 */
abstract class AbstractApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var ClientInterface
     */
    protected $configuration;

    /**
     * @param ClientInterface|null $client
     * @param Configuration|null $configuration
     */
    public function __construct(ClientInterface $client = null, Configuration $configuration = null)
    {
        $this->configuration = $configuration ?: new Configuration();
        $this->client = $client ?: new Client(
            [
                'base_uri' => $this->configuration->getHost(),
            ]
        );
    }

    /**
     * @param ResponseInterface $response)
     * @return array|null
     * @throws BadRequestException
     * @throws NotFoundException
     * @throws RemoteServiceException
     */
    public function getResult(ResponseInterface $response): array
    {
        $this->checkResponse($response);
        $body = json_decode($response->getBody()->getContents(), true);
        if (true === is_array($body) && true === array_key_exists('result', $body)) {
            return $body['result'];
        }

        return [];
    }

    protected function checkResponse(ResponseInterface $response): void
    {
        $statusCode = $response->getStatusCode();
        $body = json_decode($response->getBody()->getContents());
        switch ($statusCode) {
            case 200:
                break;
            case 400:
                if (true === empty($body['errors'])) {
                    throw new RemoteServiceException('Response status code is 400 and response has no error codes');
                }

                throw new BadRequestException($body['errors'], print_r($body['errors'], true));
            case 401:
            case 403:
                throw new RemoteServiceException('Request is not authenticated');
            case 404:
                throw new NotFoundException('Request failed, status code: 404');
            default:
                throw new RemoteServiceException('Request failed, status code: ' . $statusCode);
        }
    }
}