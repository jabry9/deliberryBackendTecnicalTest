<?php

namespace DeliberryAPI\Product\Category\Infrastructure\Domain\Persistence\Doctrine;

use DeliberryAPI\Product\Category\Domain\Model\CategoryState;
use DeliberryAPI\Product\Category\Domain\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;

final class DoctrineCategoryRepository implements CategoryRepository
{
    public function __construct(
        private EntityManager $entityManager
    )
    {
    }

    public function ofId(string $categoryId): ?CategoryState
    {
        return $this
            ->entityManager
            ->createQueryBuilder()
            ->select('category')
            ->from(CategoryState::class, 'category')
            ->where('category.categoryId = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}