<?php

namespace App\QueryBuilder;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;

class QueryExecutionService implements QueryExecutionServiceInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param array<Query> $queries
     * @throws Exception
     */
    public function execute(array $queries): void
    {
        $this->entityManager->getConnection()->beginTransaction();

        try {
            foreach ($queries as $query) {
                $this->entityManager->getConnection()->executeQuery($query->getQueryString(), $query->getQueryParams());
            }

            $this->entityManager->getConnection()->commit();
        } catch (Exception $exception) {
            $this->entityManager->getConnection()->rollBack();

            throw $exception;
        }

    }
}