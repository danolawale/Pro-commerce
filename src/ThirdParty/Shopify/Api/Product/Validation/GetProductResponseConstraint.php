<?php

namespace App\ThirdParty\Shopify\Api\Product\Validation;

use Symfony\Component\Validator\Constraint;

class GetProductResponseConstraint extends Constraint
{
    public string $message = 'shopify.product.get.request.message';
}