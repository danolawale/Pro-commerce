<?php

namespace App\Security;

use Symfony\Bundle\SecurityBundle\Security;

class SecurityAccessHelper
{
    public function __construct(
        private readonly Security $security
    ){
    }

    public function isAdminUser(): bool
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }

    public function isStandardUser(): bool
    {
        return $this->security->isGranted('ROLE_USER');
    }

    public function isAdminOrStandardUser(): bool
    {
        return $this->isAdminUser() || $this->isStandardUser();
    }
}