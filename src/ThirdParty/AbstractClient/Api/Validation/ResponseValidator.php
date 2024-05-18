<?php

namespace App\ThirdParty\AbstractClient\Api\Validation;

use App\ThirdParty\AbstractClient\Api\Response\ResponseInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ResponseValidator implements ResponseValidatorInterface
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly Constraint $constraint,
    ) {
    }

    public function validateResponse(ResponseInterface $response): void
    {
        $errors = $this->validator->validate($response, $this->constraint);

        if ($errors->count() > 0) {
            throw new ValidationFailedException('Response Validation failed', $errors);
        }
    }
}