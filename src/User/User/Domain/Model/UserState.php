<?php

namespace DeliberryAPI\User\User\Domain\Model;

use DeliberryAPI\Core\User\Domain\Model\UserLoggedInterface;


class UserState implements UserLoggedInterface
{

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';

    public function __construct(private readonly string $userId, private string $username, private array $roles)
    {
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return null;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }

}