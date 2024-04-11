<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Security\SecurityAccessHelper;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    private const CREATE_USER = 'CREATE_USER';
    private const UPDATE_USER = 'UPDATE_USER';
    private const VIEW_USER = 'VIEW_USER';

    public function __construct(
        private readonly SecurityAccessHelper $securityAccessHelper
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return
            $subject instanceof User
            && in_array(
                $attribute,
                [self::VIEW_USER, self::CREATE_USER, self::UPDATE_USER]
            );
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        return match($attribute) {
            self::VIEW_USER => $this->canViewUser($subject, $token),
            self::CREATE_USER => $this->canCreateUser($subject, $token),
            self::UPDATE_USER => $this->canUpdateUser($subject, $token),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canViewUser(User $user, TokenInterface $token): bool
    {
        return $this->securityAccessHelper->isAdminOrStandardUser() && $token->getUser() === $user;
    }

    private function canCreateUser(User $user, TokenInterface $token): bool
    {
        return $this->securityAccessHelper->isAdminUser();
    }

    private function canUpdateUser(User $user, TokenInterface $token): bool
    {
        return $this->securityAccessHelper->isAdminOrStandardUser() && $token->getUser() === $user;
    }
}
