<?php

namespace App\Component\Import\Product\Query\Builders;

use App\Component\Import\Product\Dto\ProductOptionsDto;
use App\Entity\ProductOption;
use App\QueryBuilder\Query;
use App\QueryBuilder\QueryBuilderServiceInterface;
use App\QueryBuilder\QueryBuilderTrait;
use App\Repository\ProductOptionRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductVariantRepository;

final class ProductOptionQueryBuilder implements QueryBuilderServiceInterface
{
    use QueryBuilderTrait;

    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductOptionRepository $productOptionRepository,
    ) {
    }

    public function build(array $data): array
    {
        $product = $this->productRepository->findOneBy(['sku' => $data['id']]);
        $productOptions = ProductOptionsDto::create($data, $product?->getId());

        $queries = [];

        foreach ($productOptions as $productOption) {
            $existingProductOption = $this->productOptionRepository->findOneBy([
                'product' => $product,
                'externalId' => $productOption->external_id
            ]);

            if (null !==  $existingProductOption) {
                $productOption->id = $existingProductOption->getId();
                $queries[] = $this->updateProductOption($productOption);

                continue;
            }

            $queries[] = $this->createProductOption($productOption, $data['id']);
        }

        return $queries;
    }

    private function updateProductOption(ProductOptionsDto $productOption): Query
    {
        return $this->getUpdateQuery(
            $productOption->toArray(),
            'id',
            ProductOptionRepository::TABLE_NAME
        );
    }

    private function createProductOption(ProductOptionsDto $productOption, string $productSku): Query
    {
        $productOptionData = $productOption->toArray();

        if ($productOption->product_id) {
            return $this->getCreateQuery($productOptionData, ProductOptionRepository::TABLE_NAME);
        }

        $selectFieldsMapping = ['id' => 'product_id'];

        $selectParams = ['sku' => $productSku];

        return $this->getCreateFromSelectQuery(
            $productOptionData,
            ProductOptionRepository::TABLE_NAME,
            $selectFieldsMapping,
            $selectParams,
            ProductRepository::TABLE_NAME
        );
    }
}