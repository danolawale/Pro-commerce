<?php

namespace App\ThirdParty\AbstractClient\Api\Request;

interface RequestInterface
{
    public function getMethod(): string;
    public function getEndpoint(): string;
    public function getRequestUrl(): string;
    public function getRequestOptions(): array;
    public function getRequestFilters(): array;
}