<?php


namespace DeliberryAPI\Core\User\Domain\Model;


use Symfony\Component\Security\Core\User\UserInterface;

interface UserLoggedInterface extends UserInterface
{
    public function userId(): string;
}