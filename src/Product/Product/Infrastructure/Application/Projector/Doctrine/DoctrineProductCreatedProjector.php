<?php

namespace DeliberryAPI\Product\Product\Infrastructure\Application\Projector\Doctrine;

use DeliberryAPI\Core\Event\Application\Projector\Projector;
use DeliberryAPI\Core\Event\Domain\Model\DomainEvent;
use DeliberryAPI\Product\Product\Domain\Event\ProductCreated;
use DeliberryAPI\Product\Product\Domain\Model\ProductState;
use DeliberryAPI\Product\Product\Domain\Repository\ProductRepository;

final class DoctrineProductCreatedProjector implements Projector
{

    public function __construct(private readonly ProductRepository $productRepository)
    {
    }


    public function project(DomainEvent|ProductCreated $domainEvent): void
    {
        $productState = new ProductState(
            $domainEvent->productId,
            $domainEvent->name,
            $domainEvent->description,
            $domainEvent->categoryId,
            $domainEvent->price
        );

        $this->productRepository->add($productState);
    }

    public static function eventNameProjected(): array
    {
        return [
            ProductCreated::eventName()
        ];
    }
}