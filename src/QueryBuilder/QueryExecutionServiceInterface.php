<?php

namespace App\QueryBuilder;

interface QueryExecutionServiceInterface
{
    public function execute(array $queries): void;
}