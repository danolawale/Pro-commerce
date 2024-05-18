<?php

namespace App\Component\Import\Product\Dto;

class ProductOptionsDto
{
    public function __construct(
        public ?int $id,
        public readonly ?string $external_id,
        public readonly ?int $product_id,
        public readonly ?string $external_product_id,
        public readonly string $name,
        public readonly int $position,
        public readonly string $option_values,
    ) {
    }

    /**
     * @return array<ProductOptionsDto>
     */
    public static function create(array $data,  ?int $productId): array
    {
        $productOptions = $data['options'] ?? [];

        $productOptionsDtos = [];

        foreach ($productOptions as $productOption) {
            $productOptionsDtos[] = new self(
                id: null,
                external_id: $productOption['id'],
                product_id: $productId,
                external_product_id: $productOption['product_id'],
                name: $productOption['name'],
                position: $productOption['position'],
                option_values: implode(',', $productOption['values'])
            );
        }

        return $productOptionsDtos;
    }

    public function toArray(): array
    {
        return (array)$this;
    }
}