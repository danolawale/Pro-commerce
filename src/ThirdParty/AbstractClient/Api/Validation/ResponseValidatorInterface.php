<?php

namespace App\ThirdParty\AbstractClient\Api\Validation;

use App\ThirdParty\AbstractClient\Api\Response\ResponseInterface;

interface ResponseValidatorInterface
{
    public function validateResponse(ResponseInterface $response): void;
}