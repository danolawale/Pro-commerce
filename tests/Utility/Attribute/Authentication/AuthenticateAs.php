<?php

namespace App\Tests\Utility\Attribute\Authentication;

use Attribute;

#[Attribute]
class AuthenticateAs
{
    public function __construct(
        private readonly string $username,
        private readonly ?string $password = 'test5555'
    ) {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}