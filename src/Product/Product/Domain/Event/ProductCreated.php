<?php

namespace DeliberryAPI\Product\Product\Domain\Event;

use DateTimeInterface;
use DeliberryAPI\Core\Event\Domain\Model\DomainEvent;

final class ProductCreated implements DomainEvent
{

    public function __construct(
        public readonly string $productId,
        public readonly string $name,
        public readonly string $description,
        public readonly ?string $categoryId,
        public readonly float $price,
        private readonly DateTimeInterface $occurredOn
    ) {
    }

    public function occurredOn(): DateTimeInterface
    {
        return $this->occurredOn;
    }

    public static function eventName(): string
    {
        return 'deliberryAPI.event.1.product.product.created';
    }
}