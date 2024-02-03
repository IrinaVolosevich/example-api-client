<?php

declare(strict_types=1);

namespace Tests\Ivolosevich\ExampleApiClient\API;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Ivolosevich\ExampleApiClient\API\CommentApi;
use Ivolosevich\ExampleApiClient\API\Configuration;
use Ivolosevich\ExampleApiClient\API\Model\Comment;
use Ivolosevich\ExampleApiClient\API\Model\CommentCollection;
use Ivolosevich\ExampleApiClient\API\Request\CommentData;
use Ivolosevich\ExampleApiClient\API\Request\Request;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ivolosevich\ExampleApiClient\API\CommentApi
 */
class CommentApiTest extends TestCase
{
    /**
     * @var CommentApi
     */
    private $commentApi;

    /**
     * @var ClientInterface|MockObject
     */
    private $mockClient;

    protected function setUp(): void
    {
        $this->mockClient = $this->createMock(ClientInterface::class);
        $this->commentApi = new CommentApi($this->mockClient, new Configuration());
    }

    public function testGetAll(): void
    {
        $commentData = [
            ['id' => 1, 'name' => 'User1', 'text' => 'Comment 1'],
            ['id' => 2, 'name' => 'User2', 'text' => 'Comment 2'],
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('request')
            ->with(Request::METHOD_GET, CommentApi::ENDPOINT_GET_ALL, [])
            ->willReturn(new Response(200, [], json_encode(['result' => $commentData])));

        $result = $this->commentApi->getAll();

        $this->assertInstanceOf(CommentCollection::class, $result);

        foreach ($result->toArray() as $index => $comment) {
            $this->assertInstanceOf(Comment::class, $comment);
            $this->assertSame($commentData[$index]['id'], $comment->getId());
            $this->assertSame($commentData[$index]['name'], $comment->getName());
            $this->assertSame($commentData[$index]['text'], $comment->getText());
        }
    }

    public function testCreate(): void
    {
        $commentData = new CommentData('New User', 'New Comment');

        $this->mockClient
            ->expects($this->once())
            ->method('request')
            ->with(
                Request::METHOD_POST,
                CommentApi::ENDPOINT_CREATE_ONE,
                ['json' => $commentData->toArray()]
            )
            ->willReturn(new Response(201));

        $this->commentApi->create($commentData);
    }

    public function testUpdate(): void
    {
        $commentId = 1;
        $commentData = new CommentData('Updated User', 'Updated Comment');

        $this->mockClient
            ->expects($this->once())
            ->method('request')
            ->with(
                Request::METHOD_PUT,
                sprintf(CommentApi::ENDPOINT_UPDATE_ONE, $commentId),
                ['json' => $commentData->toArray()]
            )
            ->willReturn(new Response(200));

        $this->commentApi->update($commentId, $commentData);
    }
}
