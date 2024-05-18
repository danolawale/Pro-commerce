<?php

namespace App\ThirdParty\Shopify\Api;

use App\ThirdParty\AbstractClient\Api\CustomHttpClientInterface;
use App\ThirdParty\Shopify\Api\Exception\ShopifyHttpClientException;
use App\ThirdParty\AbstractClient\Api\Request\RequestInterface;
use App\ThirdParty\AbstractClient\Api\Response\ResponseInterface;
use App\ThirdParty\Shopify\Api\Product\Response\ShopifyProductResponse;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ShopifyClient implements CustomHttpClientInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
    ) {
    }

    public function request(RequestInterface $request): ResponseInterface
    {
        try {
            $response = $this->client->request(
                $request->getMethod(),
                $request->getRequestUrl(),
                $request->getRequestOptions()
            );

            return new ShopifyProductResponse($response->toArray());

        } catch (ExceptionInterface $exception) {
            throw new ShopifyHttpClientException($exception->getMessage(), $exception->getCode());
        }
    }
}