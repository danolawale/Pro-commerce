<?php

namespace App\ThirdParty\Shopify\Api\Product;


use App\ThirdParty\AbstractClient\Api\CustomHttpClientInterface;
use App\ThirdParty\AbstractClient\Api\Response\ResponseInterface;
use App\ThirdParty\AbstractClient\Api\Validation\ResponseValidatorInterface;
use App\ThirdParty\Shopify\Api\Product\Request\GetProductById;
use App\ThirdParty\Shopify\Api\Product\Request\GetProducts;

final class ProductRequestService implements ProductRequestServiceInterface
{
    public function __construct(
        private readonly CustomHttpClientInterface $shopifyClient,
        private readonly ResponseValidatorInterface $getProductResponseValidator,
    ) {
    }

    public function getProducts(): ResponseInterface
    {
        return $this->shopifyClient->request(new GetProducts());
    }

    public function getProductById(string $identifier): ResponseInterface
    {
        $response = $this->shopifyClient->request(new GetProductById($identifier));

        $this->getProductResponseValidator->validateResponse($response);

        return $response;
    }
}