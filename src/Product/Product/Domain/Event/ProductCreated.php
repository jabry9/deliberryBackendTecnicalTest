<?php

namespace DeliberryAPI\Product\Product\Domain\Event;

use DateTimeInterface;
use DeliberryAPI\Core\Event\Domain\Model\DomainEvent;

final class ProductCreated implements DomainEvent
{

    public function __construct(
        private string $productId,
        private string $name,
        private string $description,
        private ?string $categoryId,
        private float $price,
        private DateTimeInterface $occurredOn
    ) {
    }

    public function productId(): string
    {
        return $this->productId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function categoryId(): ?string
    {
        return $this->categoryId;
    }

    public function price(): float
    {
        return $this->price;
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