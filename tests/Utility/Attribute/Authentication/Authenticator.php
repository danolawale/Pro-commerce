<?php

namespace App\Tests\Utility\Attribute\Authentication;

use ReflectionAttribute;
use ReflectionClass;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Authenticator
{
    public function __construct(
        private readonly HttpClientInterface $client,
    ) {
    }

    /**
     * @throws \ReflectionException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function authenticate(string $class, string $method): ?string
    {
        $reflectionClass = new ReflectionClass($class);
        $reflectionMethod = $reflectionClass->getMethod($method);

        $attributes = $reflectionMethod->getAttributes();
        $authenticateAsAttribute = array_values(array_filter(
            $attributes,
            static fn(ReflectionAttribute $attribute): bool => $attribute->getName() === AuthenticateAs::class
        ))[0] ?? null;

        if ($authenticateAsAttribute === null) {
            return null;
        }

        $authenticateAsAttribute = $authenticateAsAttribute->newInstance();

        $response = $this->client->request('POST', '/api/login_check', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'username' => $authenticateAsAttribute->getUsername(),
                'password' => $authenticateAsAttribute->getPassword()
            ]
        ]);

        return $response->toArray()['token'] ?? null;
    }
}