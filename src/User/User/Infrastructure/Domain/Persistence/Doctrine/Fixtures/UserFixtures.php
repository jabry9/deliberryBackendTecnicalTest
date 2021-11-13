<?php

namespace DeliberryAPI\User\User\Infrastructure\Domain\Persistence\Doctrine\Fixtures;

use DeliberryAPI\User\User\Domain\Model\UserState;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $adminUser = new UserState(
            'f2fd3d92-c534-4d7c-869a-b6a8dbcb963f',
            'Ramon_Administrador',
            [UserState::ROLE_ADMIN, UserState::ROLE_USER]
        );

        $user = new UserState(
            '18b46526-db80-452a-8338-6d07fed8febb',
            'Juan',
            [UserState::ROLE_USER]
        );

        $manager->persist($adminUser);
        $manager->persist($user);

        $manager->flush();
    }
}