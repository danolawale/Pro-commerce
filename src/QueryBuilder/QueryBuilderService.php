<?php

namespace App\QueryBuilder;

final class QueryBuilderService implements QueryBuilderServiceInterface
{
    /**
     * @param iterable<QueryBuilderServiceInterface> $queryBuilders
     */
    public function __construct(
        private iterable $queryBuilders,
    ) {
    }

    public function build(array $data): array
    {
        $queries = [];

        foreach ($this->queryBuilders as $queryBuilder) {
            $queries = array_merge($queries, $queryBuilder->build($data));
        }

        return $queries;
    }
}