<?php


namespace DeliberryAPI\User\User\Domain\Repository;


use DeliberryAPI\User\User\Domain\Model\UserState;

interface UserRepository
{
    public function ofId(string $userId): ?UserState;
    public function ofUsername(string $username): ?UserState;
}