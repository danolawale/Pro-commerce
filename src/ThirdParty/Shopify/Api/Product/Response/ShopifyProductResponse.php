<?php

namespace App\ThirdParty\Shopify\Api\Product\Response;

use App\ThirdParty\AbstractClient\Api\Response\ResponseInterface;

class ShopifyProductResponse implements ResponseInterface
{
    public function __construct(
        private array $data,
    ) {
    }

    public function getData(): array
    {
        $data = [];
        $products = $this->data['products'] ?? null;

        if (null === $products) {
            $products = array_filter([$this->data['product'] ?? null]);
        }
        //$products = !isset($products[0]) ? array_filter([$products]) : $products;
        $data['products'] = $products;
        
        return $data;
    }
}