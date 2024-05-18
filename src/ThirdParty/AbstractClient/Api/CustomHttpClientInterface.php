<?php

namespace App\ThirdParty\AbstractClient\Api;

use App\ThirdParty\AbstractClient\Api\Request\RequestInterface;
use App\ThirdParty\AbstractClient\Api\Response\ResponseInterface;

interface CustomHttpClientInterface
{
    public function request(RequestInterface $request): ResponseInterface;
}