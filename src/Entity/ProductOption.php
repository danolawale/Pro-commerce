<?php

namespace App\Entity;

use App\Repository\ProductOptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductOptionRepository::class)]
class ProductOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalId = null;

    #[ORM\ManyToOne(inversedBy: 'productOptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalProductId = null;

    #[ORM\Column(length: 32)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $optionValues = [];

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getOptionValues(): array
    {
        return $this->optionValues;
    }

    public function setOptionValues(array $optionValues): static
    {
        $this->optionValues = $optionValues;

        return $this;
    }
}
