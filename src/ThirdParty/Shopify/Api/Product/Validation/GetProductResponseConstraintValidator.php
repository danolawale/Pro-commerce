<?php

namespace App\ThirdParty\Shopify\Api\Product\Validation;

use App\ThirdParty\Shopify\Api\Product\Response\ShopifyProductResponse;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use UnexpectedValueException;

class GetProductResponseConstraintValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof GetProductResponseConstraint) {
            throw new UnexpectedValueException($constraint, GetProductResponseConstraint::class);
        }

        if (!$value instanceof ShopifyProductResponse) {
            throw new UnexpectedValueException($value, ShopifyProductResponse::class);
        }

        $products = $value->getData()['products'] ?? null;

        if (null === $products) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}