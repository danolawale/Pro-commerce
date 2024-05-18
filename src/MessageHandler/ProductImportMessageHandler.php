<?php

namespace App\MessageHandler;

use App\Component\Import\Product\Exception\ProductImportException;
use App\Component\Import\Product\Query\ProductImportQueryRunnerInterface;
use App\Message\ProductImportMessage;
use App\ThirdParty\Shopify\Api\Product\ProductRequestServiceInterface;
use Doctrine\DBAL\Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ProductImportMessageHandler
{
    public function __construct(
        private readonly ProductRequestServiceInterface $productRequestService,
        private readonly ProductImportQueryRunnerInterface $productImportQueryBuilderService,
    ) {
    }

    public function __invoke(ProductImportMessage $message): void
    {
        $productsData = $message->getExternalProductId() === null
            ? $this->productRequestService->getProducts()->getData()
            : $this->productRequestService->getProductById($message->getExternalProductId())->getData();

        foreach ($productsData['products'] as $productData) {
            $queries = $this->productImportQueryBuilderService->build($productData);

            try {
                $this->productImportQueryBuilderService->execute($queries);
            } catch (Exception $exception) {
                throw new ProductImportException($exception->getMessage());
            }
        }
    }
}