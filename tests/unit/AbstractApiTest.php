<?php

declare(strict_types=1);

namespace Tests\Ivolosevich\ExampleApiClient\API;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Ivolosevich\ExampleApiClient\API\AbstractApi;
use Ivolosevich\ExampleApiClient\API\Configuration;
use Ivolosevich\ExampleApiClient\API\Exception\NotFoundException;
use Ivolosevich\ExampleApiClient\API\Exception\RemoteServiceException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ivolosevich\ExampleApiClient\API\AbstractApi
 */
class AbstractApiTest extends TestCase
{
    /**
     * @var AbstractApi|MockObject
     */
    private $mockApi;

    /**
     * @var ClientInterface|MockObject
     */
    private $mockClient;

    /**
     * @var Configuration|MockObject
     */
    private $mockConfiguration;

    protected function setUp(): void
    {
        $this->mockClient = $this->createMock(ClientInterface::class);
        $this->mockConfiguration = $this->createMock(Configuration::class);
        $this->mockApi = $this->getMockBuilder(AbstractApi::class)
            ->setConstructorArgs([$this->mockClient, $this->mockConfiguration])
            ->getMockForAbstractClass();
    }

    public function testConstructor(): void
    {
        $this->assertInstanceOf(AbstractApi::class, $this->mockApi);
    }

    public function testGetResult(): void
    {
        $response = new Response(200, [], '{"result": [{"id": 1, "name": "test", "text": "text"}]}');

        $result = $this->invokeMethod($this->mockApi, 'getResult', [$response]);

        $this->assertNotNull($result);
    }

    public function testGetResultNoResultProperty(): void
    {
        $response = new Response(200, [], '{"data": "success"}');

        $result = $this->invokeMethod($this->mockApi, 'getResult', [$response]);

        $this->assertSame([], $result);
    }

    public function testCheckResponse200(): void
    {
        $response = new Response(200);

        $this->invokeMethod($this->mockApi, 'checkResponse', [$response]);

        $this->assertTrue(true);
    }

    public function testCheckResponse400(): void
    {
        $response = new Response(400);

        $this->expectException(RemoteServiceException::class);
        $this->expectExceptionMessage('Response status code is 400 and response has no error codes');

        $this->invokeMethod($this->mockApi, 'checkResponse', [$response]);
    }

    public function testCheckResponse401(): void
    {
        $response = new Response(401);

        $this->expectException(RemoteServiceException::class);
        $this->expectExceptionMessage('Request is not authenticated');

        $this->invokeMethod($this->mockApi, 'checkResponse', [$response]);
    }

    public function testCheckResponse403(): void
    {
        $response = new Response(403);

        $this->expectException(RemoteServiceException::class);
        $this->expectExceptionMessage('Request is not authenticated');

        $this->invokeMethod($this->mockApi, 'checkResponse', [$response]);
    }

    public function testCheckResponse404(): void
    {
        $response = new Response(404);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Request failed, status code: 404');

        $this->invokeMethod($this->mockApi, 'checkResponse', [$response]);
    }

    public function testCheckResponseUnknownStatusCode(): void
    {
        $response = new Response(500);

        $this->expectException(RemoteServiceException::class);
        $this->expectExceptionMessage('Request failed, status code: 500');

        $this->invokeMethod($this->mockApi, 'checkResponse', [$response]);
    }

    public function testCheckResponseRequestException(): void
    {
        $response = new Response(500);

        $this->expectException(RemoteServiceException::class);
        $this->expectExceptionMessage('Request failed, status code: 500');

        $this->invokeMethod($this->mockApi, 'checkResponse', [$response]);
    }

    private function invokeMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
