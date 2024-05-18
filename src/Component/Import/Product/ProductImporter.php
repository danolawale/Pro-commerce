<?php

namespace App\Component\Import\Product;

use App\Message\ProductImportMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductImporter implements ProductImporterInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function import(?string $id = null): void
    {
        $this->messageBus->dispatch(new ProductImportMessage($id));
    }
}