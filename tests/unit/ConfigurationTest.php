<?php

declare(strict_types=1);

namespace Tests\Ivolosevich\ExampleApiClient\API;

use Ivolosevich\ExampleApiClient\API\Configuration;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ivolosevich\ExampleApiClient\API\Configuration
 */
class ConfigurationTest extends TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    protected function setUp(): void
    {
        $this->configuration = new Configuration();
    }

    public function testGetSetUsername(): void
    {
        $username = 'testuser';
        $this->configuration->setUsername($username);

        $this->assertSame($username, $this->configuration->getUsername());
    }

    public function testGetSetPassword(): void
    {
        $password = 'testpassword';
        $this->configuration->setPassword($password);

        $this->assertSame($password, $this->configuration->getPassword());
    }

    public function testGetSetHost(): void
    {
        $host = 'http://example-test.com';
        $this->configuration->setHost($host);

        $this->assertSame($host, $this->configuration->getHost());
    }
}
