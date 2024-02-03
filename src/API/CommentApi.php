<?php

declare(strict_types=1);

namespace Ivolosevich\ExampleApiClient\API;

use GuzzleHttp\ClientInterface;
use Ivolosevich\ExampleApiClient\API\Model\Comment;
use Ivolosevich\ExampleApiClient\API\Model\CommentCollection;
use Ivolosevich\ExampleApiClient\API\Request\CommentData;
use Ivolosevich\ExampleApiClient\API\Request\Request;
use Throwable;

/**
 * Class CommentApi
 * @package Ivolosevich\ExampleApiClient\API
 */
class CommentApi extends AbstractApi
{
    const ENDPOINT_GET_ALL = '/comments';
    const ENDPOINT_UPDATE_ONE = '/comment/%d';
    const ENDPOINT_CREATE_ONE = '/comment';

    public function __construct(ClientInterface $client = null, Configuration $configuration = null)
    {
        parent::__construct($client, $configuration);
    }

    public function getAll(array $options = [])
    {
        try {
            $comments = $this->getResult(
                $this->client->request(
                    Request::METHOD_GET,
                    self::ENDPOINT_GET_ALL,
                    $options
                )
            );
        } catch (Throwable $exception) {
            throw $exception;
        }

        $collection = new CommentCollection();

        foreach ($comments as $comment) {
            $collection->pushItem(new Comment($comment['id'], $comment['name'], $comment['text']));
        }

        return $collection;
    }

    public function create(CommentData $commentData, array $options = []): void
    {
        try {
            $this->client->request(
                Request::METHOD_POST,
                self::ENDPOINT_CREATE_ONE,
                array_merge(
                    [
                        'json' => $commentData->toArray(),
                    ],
                    $options
                )
            );
        } catch (Throwable $exception) {
            throw $exception;
        }
    }

    public function update(int $commentId, CommentData $commentData, array $options = []): void
    {
        try {
            $this->client->request(
                Request::METHOD_PUT,
                sprintf( self::ENDPOINT_UPDATE_ONE, $commentId),
                array_merge(
                    [
                        'json' => array_filter($commentData->toArray()),
                    ],
                    $options
                )
            );
        } catch (Throwable $exception) {
            throw $exception;
        }
    }
}