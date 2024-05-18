<?php

namespace App\Tests\Functional\ThirdParty\Shopify\Api\Product;

use App\Tests\AbstractApiTestCase;
use App\ThirdParty\AbstractClient\Api\Validation\ResponseValidatorInterface;
use App\ThirdParty\Shopify\Api\Product\ProductRequestService;
use App\ThirdParty\Shopify\Api\Product\Response\ShopifyProductResponse;

class ProductRequestServiceTest extends AbstractApiTestCase
{
    private ?ResponseValidatorInterface $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = $this->getContainer()->get('test.app.third-party.shopify.api.product.validation.get-product-response-constraint-validator');
    }

    public function test_single_product(): void
    {
        $this->createClientWithMockResponses('shopify-product', [
            ['directory' => 'Shopify', 'filename' => 'single-product-response']
        ]);

        $service = new ProductRequestService($this->mockClient, $this->validator);

        $response = $service->getProductById(1);

        $this->assertInstanceOf(ShopifyProductResponse::class, $response);
    }
}