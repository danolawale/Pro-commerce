<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Client\Factory\MockClientWithResponseFactory;
use App\Tests\Utility\Attribute\Authentication\Authenticator;
use App\ThirdParty\AbstractClient\Api\CustomHttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpClient\Exception\JsonException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class AbstractApiTestCase extends ApiTestCase
{
    Use RefreshDatabaseTrait;

    protected ?EntityManagerInterface $entityManager;
    protected CustomHttpClientInterface $mockClient;

    private const FIXTURES_PATH = __DIR__ . '/Fixtures';

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

    /**
     * @throws FileNotFoundException
     * @throws JsonException
     */
    protected function createClientWithMockResponses(string $clientName, array $filePaths): void
    {
        $responses = [];
        foreach ($filePaths as $path) {
            $file = sprintf(
                '%s/%s/%s.json',
                self::FIXTURES_PATH,
                $path['directory'] ?? '',
                $path['filename'] ?? ''
            );

            if (!file_exists($file)) {
                throw new FileNotFoundException(sprintf("The file '%s' was not found", $file));
            }

            $response = json_decode(file_get_contents($file), true);
            if (!$response) {
                throw new JsonException(sprintf("The json specified in file '%s' is invalid.", $file));
            }

            $responses[] = $response;
        }

        $this->mockClient = (new MockClientWithResponseFactory())->create($clientName, $responses);
        $this->getContainer()->set('mock_http.client', $this->mockClient);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}