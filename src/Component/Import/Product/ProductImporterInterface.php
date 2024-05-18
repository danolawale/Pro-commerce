<?php

namespace App\Component\Import\Product;

interface ProductImporterInterface
{
    public function import(?string $id = null): void;
}