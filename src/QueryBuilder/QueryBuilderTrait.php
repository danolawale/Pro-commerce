<?php

namespace App\QueryBuilder;

trait QueryBuilderTrait
{
    private function getCreateQuery(array $data, string $tableName): Query
    {
        unset($data['id']);

        $fields = array_keys($data);

        $columns = implode(', ', $fields);

        $placeholders = implode(', ', array_fill(0, count($fields), '?'));

        $query = "INSERT INTO {$tableName} ($columns) VALUES($placeholders)";

        return new Query($query, array_values($data));
    }

    private function getCreateFromSelectQuery(
        array $data,
        string $tableName,
        array $selectFieldsMapping,
        array $selectParams,
        string $selectTable
    ): Query {
        unset($data['id']);

        $selectFields = array_keys($selectFieldsMapping);
        $insertFields = array_values($selectFieldsMapping);

        //unset fields from $data to be obtained from the select statement
        foreach ($insertFields as $field) {
            unset($data[$field]);
        }

        $fields = array_keys($data);

        $fieldsForInsert = array_merge($insertFields, $fields);
        $columns = implode(', ', $fieldsForInsert);

        $placeholders = array_fill(0, count($fields), '?');
        $selectFields = array_merge($selectFields, $placeholders);

        $select = $this->getSelectWithFilters($selectFields, array_keys($selectParams), $selectTable);

        $query = sprintf("INSERT INTO %s (%s) %s", $tableName, $columns, $select);

        return new Query($query, array_merge(array_values($data), array_values($selectParams)));
    }

    private function getUpdateQuery(array $data, string $primaryKey, string $tableName): Query
    {
        $primaryKeyValue = $data[$primaryKey];
        unset($data[$primaryKey]);

        $updateParams = array_reduce(array_keys($data), fn($acc, $ele) => $acc .= "{$ele} = ?,");
        $updateParams = substr($updateParams, 0, -1);

        $query = "UPDATE {$tableName} SET  {$updateParams} WHERE {$primaryKey} = ?";
        $params = array_values($data);
        $params[] = $primaryKeyValue;

        return new Query($query, $params);
    }

    private function getSelectWithFilters(array $selectFields, array $filters, string $selectTable): string
    {
        $where = array_reduce($filters, function(string $carry, string $filter) {
            return " $carry ". sprintf('%s = ? AND', $filter);
        }, ' WHERE ') ?: '';

        $where = rtrim($where, ' AND');

        $selectFields = implode(', ', $selectFields);

        return sprintf("SELECT %s FROM %s %s", $selectFields, $selectTable, $where);
    }
}