<?php

namespace App\Entity;

use App\Repository\ProductVariantRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductVariantRepository::class)]
class ProductVariant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalProductId = null;

    #[ORM\Column(length: 255)]
    private ?string $sku = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(nullable: true)]
    private ?int $compareAtPrice = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column]
    private ?float $weightInGrams = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $barcode = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $option1 = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $option2 = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $option3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $inventoryId = null;

    #[ORM\Column(nullable: true)]
    private ?int $inventoryQuantity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $inventoryManagement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fulfillmentService = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $modifiedAt = null;

    #[ORM\ManyToOne(inversedBy: 'productVariants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

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

    public function getExternalProductId(): ?string
    {
        return $this->externalProductId;
    }

    public function setExternalProductId(?string $externalProductId): static
    {
        $this->externalProductId = $externalProductId;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): static
    {
        $this->sku = $sku;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCompareAtPrice(): ?int
    {
        return $this->compareAtPrice;
    }

    public function setCompareAtPrice(?int $compareAtPrice): static
    {
        $this->compareAtPrice = $compareAtPrice;

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

    public function getWeightInGrams(): ?float
    {
        return $this->weightInGrams;
    }

    public function setWeightInGrams(float $weightInGrams): static
    {
        $this->weightInGrams = $weightInGrams;

        return $this;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(?string $barcode): static
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getOption1(): ?string
    {
        return $this->option1;
    }

    public function setOption1(?string $option1): static
    {
        $this->option1 = $option1;

        return $this;
    }

    public function getOption2(): ?string
    {
        return $this->option2;
    }

    public function setOption2(?string $option2): static
    {
        $this->option2 = $option2;

        return $this;
    }

    public function getOption3(): ?string
    {
        return $this->option3;
    }

    public function setOption3(?string $option3): static
    {
        $this->option3 = $option3;

        return $this;
    }

    public function getImageId(): ?string
    {
        return $this->imageId;
    }

    public function setImageId(string $imageId): static
    {
        $this->imageId = $imageId;

        return $this;
    }

    public function getInventoryId(): ?string
    {
        return $this->inventoryId;
    }

    public function setInventoryId(?string $inventoryId): static
    {
        $this->inventoryId = $inventoryId;

        return $this;
    }

    public function getInventoryQuantity(): ?int
    {
        return $this->inventoryQuantity;
    }

    public function setInventoryQuantity(?int $inventoryQuantity): static
    {
        $this->inventoryQuantity = $inventoryQuantity;

        return $this;
    }

    public function getInventoryManagement(): ?string
    {
        return $this->inventoryManagement;
    }

    public function setInventoryManagement(?string $inventoryManagement): static
    {
        $this->inventoryManagement = $inventoryManagement;

        return $this;
    }

    public function getFulfillmentService(): ?string
    {
        return $this->fulfillmentService;
    }

    public function setFulfillmentService(?string $fulfillmentService): static
    {
        $this->fulfillmentService = $fulfillmentService;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeInterface $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;

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
}
