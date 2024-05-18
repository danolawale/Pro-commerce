<?php

namespace App\Tests\Client;

use App\ThirdParty\AbstractClient\Api\CustomHttpClientInterface;
use App\ThirdParty\AbstractClient\Api\Request\RequestInterface;
use App\ThirdParty\AbstractClient\Api\Response\ResponseInterface;
use App\ThirdParty\Shopify\Api\Product\Response\ShopifyProductResponse;

class MockShopifyProductClient implements CustomHttpClientInterface
{
    public function __construct(
        private array $responses,
    ) {
    }

    public function request(RequestInterface $request): ResponseInterface
    {
        $response = array_pop($this->responses);

        return new ShopifyProductResponse($response);
    }
}