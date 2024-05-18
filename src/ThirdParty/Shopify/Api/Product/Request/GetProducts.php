<?php

namespace App\ThirdParty\Shopify\Api\Product\Request;

use App\ThirdParty\AbstractClient\Api\Request\AbstractRequest;
use Symfony\Component\HttpFoundation\Request;

class GetProducts extends AbstractRequest
{
    private const ENDPOINT = 'products.json';

    public function getMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}