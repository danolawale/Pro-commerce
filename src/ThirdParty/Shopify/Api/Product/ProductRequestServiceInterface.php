<?php

namespace App\ThirdParty\Shopify\Api\Product;

use App\ThirdParty\AbstractClient\Api\Response\ResponseInterface;

interface ProductRequestServiceInterface
{
    public function getProducts(): ResponseInterface;
    public function getProductById(string $identifier): ResponseInterface;
}