<?php

namespace App\ThirdParty\Shopify\Api\Product\Request;

use App\ThirdParty\AbstractClient\Api\Request\AbstractRequest;
use Symfony\Component\HttpFoundation\Request;

class GetProductById extends AbstractRequest
{
    private const ENDPOINT = 'products';

    public function __construct(
        private readonly string $identifier,
    ) {
    }

    public function getMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getEndpoint(): string
    {
        return sprintf("%s/%s.json", self::ENDPOINT, $this->identifier);
    }
}