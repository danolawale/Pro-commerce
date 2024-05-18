<?php

namespace App\Component\Import\Product\Query\Builders;

use App\Component\Import\Product\Dto\ProductVariantDto;
use App\Entity\ProductVariant;
use App\QueryBuilder\Query;
use App\QueryBuilder\QueryBuilderServiceInterface;
use App\QueryBuilder\QueryBuilderTrait;
use App\Repository\ProductRepository;
use App\Repository\ProductVariantRepository;

final class ProductVariantQueryBuilder implements QueryBuilderServiceInterface
{
    use QueryBuilderTrait;

    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductVariantRepository $productVariantRepository,
    ) {
    }

    public function build(array $data): array
    {
        $product = $this->productRepository->findOneBy(['sku' => $data['id']]);
        $productVariants = ProductVariantDto::create($data, $product?->getId());

        $queries = [];

        foreach ($productVariants as $productVariant) {

            /**
             * @var ProductVariant|null $existingProductVariant
             */
            $existingProductVariant = $this->productVariantRepository->findOneBy([
                'product' => $product,
                'externalId' => $productVariant->external_id
            ]);

            if (null !== $existingProductVariant) {
                $productVariant->id = $existingProductVariant->getId();
                $queries[] = $this->updateProductVariant($productVariant);

                continue;
            }

            $queries[] = $this->createProductVariant($productVariant, $data['id']);
        }

        return $queries;
    }

    private function updateProductVariant(ProductVariantDto $productVariant): Query
    {
        return $this->getUpdateQuery($productVariant->toArray(), 'id', ProductVariantRepository::TABLE_NAME);
    }

    private function createProductVariant(ProductVariantDto $productVariant, string $productSku): Query
    {
        $productVariantData = $productVariant->toArray();

        if ($productVariant->product_id) {
            return $this->getCreateQuery($productVariantData, ProductVariantRepository::TABLE_NAME);
        }

        $selectFieldsMapping = ['id' => 'product_id'];

        $selectParams = ['sku' => $productSku];

        return $this->getCreateFromSelectQuery(
            $productVariantData,
            ProductVariantRepository::TABLE_NAME,
            $selectFieldsMapping,
            $selectParams,
            ProductRepository::TABLE_NAME
        );
    }
}