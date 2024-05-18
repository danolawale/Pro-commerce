<?php

namespace App\Tests\Client\Factory;

use App\Tests\Client\MockShopifyProductClient;
use App\ThirdParty\AbstractClient\Api\CustomHttpClientInterface;
use InvalidArgumentException;

class MockClientWithResponseFactory
{
    public function create(string $clientName, array $responses): CustomHttpClientInterface
    {
        return match($clientName) {
            'shopify-product' => new MockShopifyProductClient($responses),
            default => throw new InvalidArgumentException(
                sprintf("Client name '%s' not recognized", $clientName)
            )
        };
    }
}