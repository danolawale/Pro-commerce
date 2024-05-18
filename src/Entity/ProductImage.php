<?php

namespace App\Entity;

use App\Repository\ProductImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductImageRepository::class)]
class ProductImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalId = null;

    #[ORM\ManyToOne(inversedBy: 'productImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalProductId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alt = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $position = null;

    #[ORM\Column]
    private ?int $width = null;

    #[ORM\Column]
    private ?int $height = null;

    #[ORM\Column(length: 255)]
    private ?string $source = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $variantIds = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): static
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getExternalProductId(): ?string
    {
        return $this->externalProductId;
    }

    public function setExternalProductId(?string $externalProductId): static
    {
        $this->externalProductId = $externalProductId;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): static
    {
        $this->alt = $alt;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getVariantIds(): array
    {
        return $this->variantIds;
    }

    public function setVariantIds(array $variantIds): static
    {
        $this->variantIds = $variantIds;

        return $this;
    }
}
