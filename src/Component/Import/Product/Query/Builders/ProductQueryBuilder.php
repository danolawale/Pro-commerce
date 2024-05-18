<?php

namespace App\Component\Import\Product\Query\Builders;

use App\Component\Import\Product\Dto\ProductDto;
use App\QueryBuilder\Query;
use App\QueryBuilder\QueryBuilderServiceInterface;
use App\QueryBuilder\QueryBuilderTrait;
use App\Repository\ProductRepository;

final class ProductQueryBuilder implements QueryBuilderServiceInterface
{
    use QueryBuilderTrait;

    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    public function build(array $data): array
    {
        $product = ProductDto::create($data);

        $existingProduct = $this->productRepository->findOneBy(['sku' => $data['id']]);

        if ($existingProduct) {
            $product->id = $existingProduct->getId();

            return [$this->updateProduct($product)];
        }

        return [$this->createProduct($product)];
    }

    private function updateProduct(ProductDto $product): Query
    {
        $productData = $product->toArray();
        unset($productData['created_at']);

        return $this->getUpdateQuery($productData, 'id', ProductRepository::TABLE_NAME);
    }

    private function createProduct(ProductDto $product): Query
    {
        return $this->getCreateQuery($product->toArray(), ProductRepository::TABLE_NAME);
    }
}