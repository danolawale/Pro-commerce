<?php

namespace App\QueryBuilder;

interface QueryBuilderServiceInterface
{
    public function build(array $data): array;
}