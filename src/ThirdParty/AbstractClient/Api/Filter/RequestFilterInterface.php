<?php

namespace App\ThirdParty\AbstractClient\Api\Filter;

interface RequestFilterInterface
{
    public function getKey(): string;
    public function getValue(): string;
}