<?php

namespace App\Component\Import\Product\Dto;

class ProductImagesDto
{
    public function __construct(
        public ?int $id,
        public readonly ?string $external_id,
        public readonly ?int $product_id,
        public readonly ?string $external_product_id,
        public readonly ?string $alt,
        public readonly int $position,
        public readonly int $width,
        public readonly int $height,
        public readonly string $source,
        public readonly string $variant_ids,
    ) {
    }

    /**
     * @return array<ProductImagesDto>
     */
    public static function create(array $data, ?int $productId): array
    {
        $images = $data['images'] ?? [];

        $productImageDtos = [];

        foreach ($images as $image) {
            $productImageDtos[] = new self(
                id: null,
                external_id: $image['id'],
                product_id: $productId,
                external_product_id: $image['product_id'],
                alt: $image['alt'],
                position: $image['position'],
                width: $image['width'],
                height: $image['height'],
                source: $image['src'],
                variant_ids: implode(', ', $image['variant_ids'])
            );
        }

        return $productImageDtos;
    }

    public function toArray(): array
    {
        return (array)$this;
    }
}