<?php

namespace App\Component\Import\Product\Dto;

use DateTimeImmutable;
use DateTimeZone;

class ProductDto
{
    public function __construct(
        public ?int $id,
        public readonly ?string $external_id,
        public readonly string $sku,
        public readonly string $title,
        public readonly string $description,
        public readonly string $slug,
        public readonly string $status,
        public readonly string $availability,
        public readonly string $vendor,
        public readonly string $product_type,
        public readonly string $tags,
        public readonly ?string $created_at,
        public readonly string $modified_at,
    ) {
    }

    public static function create(array $data): self
    {
        return new self(
            id: null,
            external_id: $data['id'] ?? null,
            sku: $data['sku'] ?? $data['id'],
            title: $data['title'],
            description: $data['body_html'],
            slug: sprintf("%s-%s", $data['handle'], $data['id'] ?? ''),
            status: $data['status'],
            availability: $data['availability'] ?? 'available',
            vendor: $data['vendor'],
            product_type: $data['product_type'],
            tags: $data['tags'],
            created_at: isset($data['created_at'])
                ? DateTimeImmutable::createFromFormat(
                'Y-m-d\TH:i:sP',
                $data['created_at']
            )->setTimezone(new DateTimeZone('America/Edmonton'))->format('Y-m-d H:i:s')
            : null,
            modified_at: DateTimeImmutable::createFromFormat(
                'Y-m-d\TH:i:sP',
                $data['updated_at']
            )->setTimezone(new DateTimeZone('America/Edmonton'))->format('Y-m-d H:i:s'),
        );
    }

    public function toArray(): array
    {
        return (array)$this;
    }
}