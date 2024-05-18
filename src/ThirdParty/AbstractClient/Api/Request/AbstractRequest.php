<?php

namespace App\ThirdParty\AbstractClient\Api\Request;

use App\ThirdParty\AbstractClient\Api\Filter\RequestFilterInterface;

abstract class AbstractRequest implements RequestInterface
{
    protected const BASE_URI = 'https://be83ed-7c.myshopify.com/admin/api/2024-04';

    abstract public function getMethod(): string;

    abstract public function getEndpoint(): string;

    public function getRequestUrl(): string
    {
       return sprintf("%s/%s", self::BASE_URI, $this->getEndpoint());
    }

    /**
     * @return array<RequestFilterInterface>
     */
    public function getRequestFilters(): array
    {
        return [];
    }

    public function getRequestOptions(): array
    {
        $filters = $this->getRequestFilters();

        return array_reduce(
            $filters,
            static fn(
                array $carry,
                RequestFilterInterface $filter
            ) => array_merge($carry, [$filter->getKey() => $filter->getValue()]),
            []
        );
    }
}