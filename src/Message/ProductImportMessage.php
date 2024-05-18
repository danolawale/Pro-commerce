<?php

namespace App\Message;

class ProductImportMessage
{
    public function __construct(private readonly ?string $externalProductId = null)
    {
    }

    public function getExternalProductId(): ?string
    {
        return $this->externalProductId;
    }
}