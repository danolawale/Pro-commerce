<?php

namespace App\QueryBuilder;

abstract class AbstractQueryBuilder implements QueryBuilderServiceInterface
{
    /**
     * @var iterable<QueryBuilderServiceInterface> $queryBuilders
     */
    protected iterable $queryBuilders;

    public function setQueryBuilders(iterable $queryBuilders): void
    {
        $this->queryBuilders = $queryBuilders;
    }
}