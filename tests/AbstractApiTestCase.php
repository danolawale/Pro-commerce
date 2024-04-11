<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Utility\Attribute\Authentication\Authenticator;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use ReflectionClass;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class AbstractApiTestCase extends ApiTestCase
{
    Use RefreshDatabaseTrait;

    protected ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    protected function client(): HttpClientInterface
    {
        return static::createClient();
    }

    /**
     * @throws \ReflectionException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    protected function request(string $method, string $url, ?array $options = []): ResponseInterface
    {
        $token = null;
        $methodUnderTest = debug_backtrace()[1]['function'];

        $authenticator = new Authenticator($this->client());
        $token = $authenticator->authenticate(static::class, $methodUnderTest);

        if ($token !== null) {
            $headers = $options['headers'] ?? [];
            $headers = array_merge($headers, ['Authorization' => 'Bearer '. $token]);
            $options['headers'] = $headers;
        }

        return $this->client()->request($method, $url, $options);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}