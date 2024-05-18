<?php

namespace App\Component\Import\Product\Dto;

use DateTimeImmutable;
use DateTimeZone;

class ProductVariantDto
{
    public function __construct(
        public ?int $id,
        public readonly ?string $external_id,
        public readonly ?int $product_id,
        public readonly ?string $external_product_id,
        public readonly string $sku,
        public readonly string $title,
        public readonly int $price,
        public readonly ?int $compare_at_price,
        public readonly int $position,
        public readonly float $weight_in_grams,
        public readonly ?string $barcode,
        public readonly ?string $option1,
        public readonly ?string $option2,
        public readonly ?string $option3,
        public readonly ?string $image_id,
        public readonly ?string $inventory_id,
        public readonly ?string $inventory_quantity,
        public readonly ?string $inventory_management,
        public readonly ?string $fulfillment_service,
        public readonly ?string $created_at,
        public readonly string $modified_at,
    ) {
    }

    /**
     * @return array<ProductVariantDto>
     */
    public static function create(array $data, ?int $productId): array
    {
        $variants = $data['variants'] ?? [];

        $variantEntities = [];

        foreach ($variants as $variant) {
            $variantEntities[] = new self(
                id: null,
                external_id: $variant['id'],
                product_id: $productId,
                external_product_id: $variant['product_id'],
                sku: $variant['sku'],
                title: $variant['title'],
                price: $variant['price'] * 100,
                compare_at_price: ($variant['compare_at_price'] ?: 0) * 100,
                position: $variant['position'],
                weight_in_grams: $variant['grams'],
                barcode: $variant['barcode'],
                option1: $variant['option1'],
                option2: $variant['option2'],
                option3: $variant['option3'],
                image_id: $variant['image_id'],
                inventory_id: $variant['inventory_item_id'],
                inventory_quantity: $variant['inventory_quantity'],
                inventory_management: $variant['inventory_management'],
                fulfillment_service: $variant['fulfillment_service'],
                created_at: isset($variant['created_at'])
                    ? DateTimeImmutable::createFromFormat(
                    'Y-m-d\TH:i:sP',
                    $variant['created_at']
                )->setTimezone(new DateTimeZone('America/Edmonton'))->format('Y-m-d H:i:s')
                : null,
                modified_at: DateTimeImmutable::createFromFormat(
                    'Y-m-d\TH:i:sP',
                    $variant['updated_at']
                )->setTimezone(new DateTimeZone('America/Edmonton'))->format('Y-m-d H:i:s'),
            );
        }

        return $variantEntities;
    }

    public function toArray(): array
    {
        return (array)$this;
    }
}