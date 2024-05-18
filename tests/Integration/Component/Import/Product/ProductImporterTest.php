<?php

namespace App\Tests\Integration\Component\Import\Product;

use App\Component\Import\Product\ProductImporter;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\ProductOption;
use App\Entity\ProductVariant;
use App\Tests\AbstractApiTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductImporterTest extends AbstractApiTestCase
{
    private ?MessageBusInterface $messageBus;

    public function setUp(): void
    {
        parent::setUp();
        $this->messageBus = $this->getContainer()->get(MessageBusInterface::class);
    }

    public function test_create_import_is_successful(): void
    {
        $this->createClientWithMockResponses('shopify-product', [
            ['directory' => 'Shopify', 'filename' => 'products-response']
        ]);

        $productsPreImport = $this->entityManager->getRepository(Product::class)->findAll();
        $this->assertCount(1, $productsPreImport);
        $this->assertEquals('632910391', $productsPreImport[0]->getSku());

        (new ProductImporter($this->messageBus))->import();

        $this->entityManager->clear();

        /**
         * @var Product[] $products
         */
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $this->assertCount(3, $products);

        $skus = array_map(
            static fn(Product $product): string => $product->getExternalId(),
            $products
        );
        $this->assertEquals(['632910391', '632910392', '921728736'], $skus);

        $variantSkus = array_map(
            static fn(ProductVariant $productVariant): string => $productVariant->getExternalId(),
            $products[1]->getProductVariants()->toArray()
        );
        $this->assertEquals(['808950810', '49148385', '39072856', '457924702'], $variantSkus);

        $imagesIds = array_map(
            static fn(ProductImage $productImage): string => $productImage->getExternalId(),
            $products[1]->getProductImages()->toArray()
        );
        $this->assertEquals(['850703190', '562641783', '378407906'], $imagesIds);

        $productOptionIds = array_map(
            static fn(ProductOption $productOption): string => $productOption->getExternalId(),
            $products[1]->getProductOptions()->toArray()
        );
        $this->assertEquals(['594680422'], $productOptionIds);
    }

    public function test_update_import_is_successful(): void
    {
        $this->createClientWithMockResponses('shopify-product', [
            ['directory' => 'Shopify', 'filename' => 'single-product-response']
        ]);

        $this->preUpdateAssertions('632910391');

        (new ProductImporter($this->messageBus))->import();

        $this->entityManager->clear();

        $this->postUpdateAssertions('632910391');
    }

    private function preUpdateAssertions(string $productSku): void
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBy(['sku' => $productSku]);
        $this->assertInstanceOf(Product::class, $product);

        $this->assertEquals($productSku, $product->getSku());
        $this->assertEquals('', $product->getVendor());
        $this->assertEquals('phone', $product->getTags());

        /**
         * @var ProductVariant[] $productVariants
         */
        $productVariants = $this->entityManager->getRepository(ProductVariant::class)->findAll();
        $this->assertCount(1, $productVariants);
        $this->assertEquals('808950809', $productVariants[0]->getExternalId());
    }

    private function postUpdateAssertions(string $productSku): void
    {
        /**
         * @var Product[] $products
         */
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $this->assertCount(1, $products);
        $this->assertEquals($productSku, $products[0]->getSku());
        $this->assertEquals('Apple', $products[0]->getVendor());
        $this->assertEquals('Emotive, Flash Memory, MP3, Music', $products[0]->getTags());

        $productVariants = $products[0]->getProductVariants()->toArray();

        $variantSkus = array_map(
            static fn(ProductVariant $productVariant): string => $productVariant->getExternalId(),
            $productVariants
        );
        $this->assertEquals(['808950809', '49148384', '39072855', '457924701'], $variantSkus);
        $this->assertEquals(19900, $productVariants[0]->getPrice());
    }
}