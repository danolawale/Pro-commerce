<?php

namespace App\QueryBuilder;

class Query
{
    public function __construct(
        private readonly string $queryString,
        private readonly array $queryParams,
    ) {
    }

    public function getQueryString(): string
    {
        return $this->queryString;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }
}