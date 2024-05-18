<?php

namespace App\Component\Import\Product\Query;

use App\QueryBuilder\QueryBuilderServiceInterface;
use App\QueryBuilder\QueryExecutionServiceInterface;

final class ProductImportQueryRunner implements ProductImportQueryRunnerInterface
{
    /**
     * @param iterable<QueryBuilderServiceInterface> $queryBuilders
     */
    public function __construct(
        private iterable $queryBuilders,
        private readonly QueryExecutionServiceInterface $queryExecutionService,
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

    public function execute(array $queries): void
    {
        $this->queryExecutionService->execute($queries);
    }
}