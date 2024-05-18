<?php

namespace App\Component\Import\Product\Query\Builders;

use App\Component\Import\Product\Dto\ProductImagesDto;
use App\QueryBuilder\Query;
use App\QueryBuilder\QueryBuilderServiceInterface;
use App\QueryBuilder\QueryBuilderTrait;
use App\Repository\ProductImageRepository;
use App\Repository\ProductRepository;

final class ProductImageQueryBuilder implements QueryBuilderServiceInterface
{
    use QueryBuilderTrait;

    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductImageRepository $productImageRepository,
    ) {
    }

    public function build(array $data): array
    {
        $product = $this->productRepository->findOneBy(['sku' => $data['id']]);

        $productImages = ProductImagesDto::create($data, $product?->getId());

        $queries = [];

        foreach ($productImages as $productImage) {
            $existingProductImage = $this->productImageRepository->findOneBy([
                'product' => $product,
                'externalId' => $productImage->external_id
            ]);

            if ($existingProductImage) {
                $productImage->id = $existingProductImage->getId();
                $queries[] = $this->updateProductImage($productImage);

                continue;
            }

            $queries[] = $this->createProductImage($productImage, $data['id']);
        }

        return $queries;
    }

    private function updateProductImage(ProductImagesDto $productImage): Query
    {
        return $this->getUpdateQuery(
            $productImage->toArray(),
            'id',
            ProductImageRepository::TABLE_NAME
        );
    }

    private function createProductImage(ProductImagesDto $productImage, string $productSku): Query
    {
        $productImageData = $productImage->toArray();

        if ($productImage->product_id) {
            return $this->getCreateQuery($productImageData, ProductImageRepository::TABLE_NAME);
        }

        $selectFieldsMapping = ['id' => 'product_id'];

        $selectParams = ['sku' => $productSku];

        return $this->getCreateFromSelectQuery(
            $productImageData,
            ProductImageRepository::TABLE_NAME,
            $selectFieldsMapping,
            $selectParams,
            ProductRepository::TABLE_NAME
        );
    }
}