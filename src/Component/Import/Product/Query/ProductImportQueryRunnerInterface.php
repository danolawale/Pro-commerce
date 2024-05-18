<?php

namespace App\Component\Import\Product\Query;

use App\QueryBuilder\QueryBuilderServiceInterface;
use App\QueryBuilder\QueryExecutionServiceInterface;

interface ProductImportQueryRunnerInterface extends QueryBuilderServiceInterface, QueryExecutionServiceInterface
{
}