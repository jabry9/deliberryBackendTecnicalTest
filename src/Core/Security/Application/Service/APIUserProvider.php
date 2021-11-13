<?php

namespace DeliberryAPI\Core\Security\Application\Service;

use DeliberryAPI\User\User\Domain\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class APIUserProvider implements UserProviderInterface
{

    public function __construct(private UserRepository $userRepository)
    {
    }


    public function loadUserByUsername(string $username)
    {
        return $this->userRepository->ofUsername($username);
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->userRepository->ofUsername($user->getUsername());
    }

    public function supportsClass(string $class)
    {
        return true;
    }
}