<?php

namespace DeliberryAPI\Product\Product\Infrastructure\Domain\Persistence\Doctrine;

use DeliberryAPI\Core\Common\Domain\Service\UuidService;
use DeliberryAPI\Product\Product\Domain\Model\ProductState;
use DeliberryAPI\Product\Product\Domain\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;

final class DoctrineProductRepository implements ProductRepository
{

    public function __construct(
        private EntityManager $entityManager
    )
    {
    }

    public function nextId(): string
    {
        return UuidService::generateVersion4();
    }

    public function add(ProductState $productState): void
    {
        $this->entityManager->persist($productState);
    }

    public function ofId(string $productId): ?ProductState
    {
        return $this
            ->entityManager
            ->createQueryBuilder()
            ->select('product')
            ->from(ProductState::class, 'product')
            ->where('product.productId = :productId')
            ->setParameter('productId', $productId)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}