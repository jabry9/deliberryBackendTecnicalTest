<?php

namespace DeliberryAPI\Product\Category\Infrastructure\Domain\Persistence\Doctrine\Fixtures;

use DeliberryAPI\Product\Category\Domain\Model\CategoryState;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class CategoryFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $manager->persist(
            new CategoryState(
                '20f79aa5-fbb5-4d83-b6c7-cfb1afa8ec37',
                'Food',
            )
        );
        $manager->persist(
            new CategoryState(
                'ab05d10c-edd7-43ed-a765-5221fa0e7b39',
                'Drinks',
            )
        );

        $manager->flush();
    }
}